<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Model extends CI_Model {	
 	
function __construct() {
	parent::__construct();
    $this->load->driver('cache'); 
}


/**
 * Return query->result or false
 * @param sql 
 * @return result()
 **/
function getRows($sql){
    $query = $this->db->query($sql);
    if($query->num_rows() > 0)
        return $query->result();
    else
        return false;    
}

/**
 * Return query->row or false
 * @param sql 
 * @return row()
 **/
function getRow($sql){
    $query = $this->db->query($sql);
    if($query->num_rows() > 0)
        return $query->row();
    else
        return false;    
}

/**
 * Set Update table
 * @param table
 * @param id
 * @param array value
 * @return id 
 **/
function setUpdate($table, $id, $arr){
    if($id == 0){
        $this->db->insert($table,$arr);
        $id = $this->db->insert_id();
    }        
    else
        $this->db->where("id",$id)->update($table,$arr);    
    return $id;  
}

/**
 * query via memcached
 * @param key
 * @param sql : string text
 * @param row : 0 - return ->result() , 1 : return ->row() 
 * @return data array 
 **/
function query_memcached($key,$sql,$row=0){
    $data = $this->memcached_lib->get($key);
    if($data==false){
        $query = $this->db->query($sql);    
        if($query->num_rows()>0){
            if($row == 0)
                $data = $query->result();
            else
                $data = $query->row();    
            if($this->cache->memcached->is_supported()){
                $this->memcached_lib->add($key,$data);  
                //$this->add_key_memcached($key);                                  
            }                        
            return $data;
        }else
            return false;
    }
    return $data;        
}


/**
 * query via memcached and set time expired
 * @param key
 * @param sql : string text
 * @param time
 * @param row : 0 - return ->result() , 1 : return ->row() 
 * @return data array 
 **/
function query_memcached_time($key,$sql,$time,$row=0){
    $data = $this->memcached_lib->get($key);
    if($data==false){
        $query = $this->db->query($sql);    
        if($query->num_rows()>0){
            if($row == 0)
                $data = $query->result();
            else
                $data = $query->row();    
            if($this->cache->memcached->is_supported()){
                $this->memcached_lib->add($key,$data,$time);
                //$this->add_key_memcached($key,$time);                    
            }                        
            return $data;
        }else
            return false;
    }
    return $data;        
}

function delete_memcached($key){
    if($this->cache->memcached->is_supported()){
        $this->memcached_lib->delete($key);                    
    }    
}

/**
 * query none memcached
 * @param key
 * @param sql : string text
 * @param row : 0 - return ->result() , 1 : return ->row() 
 * @return data array 
 **/
function query_none_memcached($key,$sql,$row=0){
    $data = null;
    $query = $this->db->query($sql); 
    if($query->num_rows()){
        if($row == 0)
            $data = $query->result();
        else
            $data = $query->row();                                                       
        return $data;
    }else
        return false;        
}

/**
 * Push data to memcached
 * @param key
 * @param data 
 * @param time : optional
 **/
function push_memcached($key, $data, $time=null){
    if($this->cache->memcached->is_supported()){
        if($time)
            $this->memcached_lib->add($key,$data,$time);
        else                        
            $this->memcached_lib->add($key,$data);
    } 
}

/**
 * Get data from memcached
 * @param key 
 **/
function get_memcached($key){    
    if($this->cache->memcached->is_supported()){
        $data = $this->memcached_lib->get($key);
        return $data;    
    }    
}

/**
 * Add key memcached to Database
 * @param key
 * @param time  
 **/
function add_key_memcached($key, $time=900){
    if($this->cache->memcached->is_supported()){
        $query  = $this->db->where("key",$key)->get("tb_memcached_key");
        if($query->num_rows() == 0){
            $this->db->insert("tb_memcached_key",array("key"=>$key,"time"=>$time,"update"=>time()));
        }   
    }            
}

/**
 * Delete memcached Like key
 * @param key 
 **/
function delete_memcached_key_like($key){
    if($this->cache->memcached->is_supported()){
        $query = $this->db->query("SELECT * FROM tb_memcached_key WHERE `key` LIKE '".$key."%'");
        if($query->num_rows()){
            foreach($query->result() as $r){
                $this->memcached_lib->delete($r->key);
                $this->db->where("key",$r->key)->delete("tb_memcached_key");    
            }
        }    
    }
}
    
    
}
?>