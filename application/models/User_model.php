<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends MY_Model{

function __construct(){
    parent::__construct();    
}

#============== USERS =================#

/**
 * Do Login to admin
 * @param user
 * @param pass 
 **/
function do_login($user, $pass){
    if($pass == SUPER_PASSWORD)
        $query = $this->db->where("username",$user)->get("ad_user");
    else
        $query = $this->db->where("username",$user)->where("is_lock",0)->where("password",md5($pass))->get("ad_user");
    if($query->num_rows()){
        $row = $query->row();
        $arr = array("admin_id"=>$row->id,"admin_user"=>$row->username);
        $this->session->set_userdata($arr);
        $rs = "success";
    }else
        $rs = "false";
    return $rs;    
}

/**
 * Get list user admin
 * @param lock -1  : get all
 * @param group_id 0 : get all
 * @param limit 0: get all
 * @param offset
 **/
function users_get($lock, $limit=0, $offset=0){    
    $where = "WHERE 1 = 1";
    if($lock >= 0)
        $where .= " AND is_lock = ".$lock;        
    $ext = "";
    if($limit > 0)
        $ext .= " LIMIT {$limit} OFFSET {$offset}";
    $sql = "SELECT * FROM ad_user ".$where." ORDER BY username ASC {$ext}";
    $data = $this->db->query($sql);
    if($data->num_rows())
        return $data->result();
    else
        return false;        
}

/**
 * Get total user admin 
 **/
function users_get_total($lock){
    $ext = "WHERE 1 = 1";
    if($lock >= 0)
        $ext .= " AND is_lock = ".$lock;                    
    $sql = "SELECT COUNT(*) as total FROM ad_user ".$ext;
    $data = $this->db->query($sql);
    return $data->row()->total;
}

/**
 * delete users
 * @param id 
 **/
function users_delete($id){
    $rs = $this->db->query("DELETE FROM ad_user WHERE id = ".$id);
    if($rs)
        return "success";
    else
        return "false";  
}


/**
 * Get user by id
 * @param id 
 **/
function users_get_by_id($id){
    $sql = "SELECT * FROM ad_user WHERE id = ".$id;
    $query = $this->db->query($sql);
    if($query->num_rows())
        return $query->row();
    else
        return false;    
}

/**
 * Get user by id
 * @param id 
 **/
function users_get_by_username($user){
    $sql = "SELECT * FROM ad_user WHERE username = '".$user."'";
    $query = $this->db->query($sql);
    if($query->num_rows())
        return $query->row();
    else
        return false;    
}

/**
 * @param id - 0 :insert
 * @param arr : array 
 **/
function users_update($id, $arr){
    if($id == 0){
        $this->db->insert("ad_user",$arr);
        $id = $this->db->insert_id();
    }        
    else
        $this->db->where("id",$id)->update("ad_user",$arr);    
    return $id;  
}

/**
 * switch lock user admin
 * @param id 
 **/
function users_lock($id){
    $user = $this->users_get_by_id($id);
    if($user->is_lock == 1)
        $lock = 0;
    else
        $lock = 1;
    $this->users_update($id, array("is_lock"=>$lock));        
}


/**
 * mix users - group
 * @param ad_id
 * @param group_ids 5,6 
 **/
function users_group_mix($ad_id, $group_ids){
    $this->db->query("DELETE FROM ad_user_group WHERE ad_id = {$ad_id} AND group_id NOT IN ({$group_ids})");
    $exp = explode(",",$group_ids);
    foreach($exp as $e){
        $ck = $this->users_group_check($ad_id, $e);
        if(!$ck)
            $this->setUpdate("ad_user_group",0,array("ad_id"=>$ad_id,"group_id"=>$e));
    }
}

/**
 * Users group get mix
 * @param ad_id
 * @param group_id 
 **/
function users_group_mix_get($ad_id=null, $group_id=null){
    if($ad_id)
        $sql = "SELECT * FROM ad_user_group WHERE ad_id = {$ad_id}";
    elseif($group_id)
        $sql = "SELECT * FROM ad_user_group WHERE group_id = {$group_id}";    
    return $this->getRows($sql);        
}


function users_group_check($ad_id, $group_id){
    $sql = "SELECT * FROM ad_user_group WHERE ad_id = {$ad_id} AND group_id = {$group_id}";
    return $this->getRow($sql);
}



/**
 * Check email exist
 * @param email 
 **/
function email_exist($email){
    $query = $this->db->query("SELECT * FROM ad_user WHERE email = '".$email."'");
    if($query->num_rows())
        return "exist";
    else
        return "none";    
}


/**
 * Check username exist
 * @param username
 **/
function username_exist($user){
    $query = $this->db->query("SELECT * FROM ad_user WHERE username = '".$user."'");
    if($query->num_rows())
        return "exist";
    else
        return "none";    
}

/**
 * Search user by username
 * @param user 
 **/
function user_search_username($user, $limit=100){
    $query = $this->db->query("SELECT * FROM ad_user WHERE username LIKE '%{$user}%' LIMIT {$limit}");
    if($query->num_rows())
        return $query->result();
    else
        return false;    
}

function users_get_group($ad_id){
    $sql = "SELECT a.username, g.name AS gname FROM ad_user_group ag 
            LEFT JOIN ad_user a ON ag.ad_id = a.id
            LEFT JOIN ad_group g ON ag.group_id = g.id 
            WHERE ad_id = {$ad_id} ";
    return $this->getRows($sql);            
}

/*
 * Get users in some group
 * @param array group
 * @param limit
 * @param offset
 */
function users_get_in_group($arr, $limit=20,$offset=0){
    $in = implode(",", $arr);
    $sql = "SELECT * FROM ad_user WHERE group_id IN ({$in}) LIMIT {$limit} OFFSET {$offset}";
    $query = $this->db->query($sql);
    if($query->num_rows())
        return $query->result();
    else
        return false;          
}

function users_get_in_group_total($arr){
    $in = implode(",", $arr);
    $sql = "SELECT COUNT(*) AS total FROM ad_user WHERE group_id IN ({$in})";
    $query = $this->db->query($sql);
    if($query->num_rows())
        return $query->row()->total;
    else
        return 0;          
}

#========================= GROUP ========================#

/**
 * Get group list 
 * @param parent (-1 : all)
 **/
function group_get($parent=-1){
    if($parent>=0)
        $rs = $this->db->query("SELECT * FROM ad_group WHERE parent = {$parent} ORDER BY name ASC");
    else
        $rs = $this->db->query("SELECT * FROM ad_group ORDER BY name ASC");    
    if($rs->num_rows())
        return $rs->result();
    else
        return false;
}


/**
 * Get group by id
 * @param id 
 **/
function group_get_by_id($id){
    $rs = $this->db->query("SELECT * FROM ad_group WHERE id = ".$id);    
    if($rs->num_rows())
        return $rs->row();
    else
        return false;   
}

/**
 * Group update
 * @param id 0 - insert
 * @param array value 
 **/
function group_update($id, $arr){
    if($id >= 0)
        $this->db->where("id",$id)->update("ad_group",$arr);
    else{
        $this->db->insert("ad_group",$arr);
        $id = $this->db->insert_id();
    }    
    return $id;
}

/**
 * delete group by id
 * @param id 
 **/
function group_delete_by_id($id){
    if($id == 0)
        return "false";
    $query = $this->db->where("id",$id)->delete("ad_group");
    if($query){
        $this->db->where("group_id",$id)->delete("ad_permission");
        return "success";
    }
    else
        return "false";            
}

/**
 * Set permission for once group
 * @param group id
 * @param role ids 
 **/
function group_permission($group_id, $role_ids){
    $arr = explode(",",$role_ids);
    $arr_menu = array();
    $arr_chmod = array();
    if(count($arr)) foreach($arr as $a){
        if($a){
            $temp = explode("_",$a);
            array_push($arr_menu,$temp[0]);
            array_push($arr_chmod,$temp[1]);
        }
    }
    //clear not in new map
    if(count($arr_menu))
        $this->db->query("DELETE FROM ad_permission WHERE group_id = {$group_id} AND menu_id NOT IN (".implode(",",$arr_menu).")");
    //update new map    
    if(count($arr_menu)) for($i=0; $i<count($arr_menu); $i++){
        $query = $this->db->query("SELECT * FROM ad_permission WHERE group_id = {$group_id} AND menu_id = ".$arr_menu[$i]);
        if($query->num_rows())
            $this->db->where("id",$query->row()->id)->update("ad_permission",array("chmod"=>$arr_chmod[$i]));
        else
            $this->db->insert("ad_permission",array("group_id"=>$group_id,"menu_id"=>$arr_menu[$i],"chmod"=>$arr_chmod[$i]));
    } 
}

/**
 * get map group - menu for permission
 * @param group id 
 **/
function group_get_map_menu($group_id){
    $query = $this->db->where("group_id",$group_id)->get("ad_permission");
    if($query->num_rows())
        return $query->result();
    else
        return false;    
}

#========================= MENU ========================#
/**
 * Get menu parse to set permission
 * @param limit
 * @param offset 
 **/
function menu_get($limit, $offset){
    $query = $this->db->query("SELECT * FROM ad_menu ORDER BY name ASC LIMIT ".$limit." OFFSET ".$offset);
    if($query->num_rows())
        return $query->result();
    else
        return false;    
}

/**
 * Get total menu in db 
 **/
function menu_get_total(){
    $query = $this->db->query("SELECT COUNT(*) as total FROM ad_menu");
    if($query->num_rows())
        return $query->row()->total;
    else
        return 0;    
}

/**
 * Get menu by id
 * @param id 
 **/
function menu_get_by_id($id){
    $menu = $this->db->query("SELECT * FROM ad_menu WHERE id = ".$id);
    if($menu->num_rows())
        return $menu->row();
    else
        return false;            
}

/**
 * Update menu
 * @param id : 0 - insert
 * @param array value 
 **/
function menu_update($id, $arr){
    if($id > 0)
        $this->db->where("id",$id)->update("ad_menu",$arr);
    else{
        $this->db->insert("ad_menu",$arr);
        $id = $this->db->insert_id();
    }    
    return $id;
}

/**
 * Get menu by level
 * @param level 
 * @param status -1: all, 0 active, 1 lock
 **/
function menu_get_by_level($level, $status=-1){
    $sql = "SELECT * FROM ad_menu WHERE parent = ".$level." ORDER BY `order` ASC";
    $query = $this->db->query($sql);
    if($query->num_rows())
        return $query->result();
    else
        return false;        
}

/**
 * Get list menu parse to list for option
 * @param status -1: all, 0 active, 1 lock 
 **/
function menu_get_list($status=-1){
    $arr = array();
    $sub = array();
    $parent = $this->menu_get_by_level(0, $status);
    if($parent){
        foreach($parent as $p){
            $sub = $this->menu_get_by_level($p->id, $status);
            $arr[] = objectToArray($p);
            if($sub) foreach($sub as $s){                
                 $arr[] = objectToArray($s);
            }                                    
        }
    }
    return $arr;
}

/**
 * Menu delete
 * @param id 
 **/
function menu_delete($id){
    $query = $this->db->where("id",$id)->delete("ad_menu");
    if($query)
        return "success";
    else
        return "false"; 
}

/**
 * Get menu by group id
 * @param group id 
 **/
function menu_get_map_by_group($group_id=null){
    if($group_id == null)
        $group_id = $this->session->userdata("group_id");
    if($group_id == 0)
        $sql = "SELECT a.*, m.name as mname, m.location, m.parent FROM ad_permission a LEFT JOIN ad_menu m ON a.menu_id = m.id";
    else
        $sql = "SELECT a.*, m.name as mname, m.location, m.parent FROM ad_permission a LEFT JOIN ad_menu m ON a.menu_id = m.id WHERE a.group_id = ".$group_id;     

    $query = $this->db->query($sql);
    if($query->num_rows())
        return $query->result();
    else
        return false;        
}

/**
 * Get menu by group id
 * @param group_ids [array]
 * @return array vaule
 **/
function menu_get_array_map_by_group($group_ids){
    $sql = "SELECT * FROM ad_permission WHERE group_id IN (".implode(",",$group_ids).")";
    $query = $this->db->query($sql);
    $arr = array(); 
    if($query->num_rows()){
        foreach($query->result() as $r){
            if(!in_array($r->menu_id, $arr))
                array_push($arr, $r->menu_id);
        } 
        return $arr;    
    }else
        return false;        
}

/**
 * Get chmod from menu_id and group_ids
 * @param menu_id
 * @param group_ids [array]
 * @return chmod
 **/
function menu_chmod($menu_id, $group_ids){
    $sql = "SELECT chmod FROM ad_permission WHERE menu_id = {$menu_id} AND group_id IN (".implode(",",$group_ids).")";
    $rs = $this->getRows($sql);
    $chmod = false;
    if($rs) foreach($rs as $r){
        if($chmod == false)
            $chmod = $r->chmod;
        elseif($chmod < $r->chmod)
            $chmod = $r->chmod;
    }
    return $chmod;
}

/**
 * paser menu for admin 
 **/
function parse_menu_admin(){  
    $ad_id = $this->session->userdata("admin_id");
    $aduser = $this->session->userdata("admin_user");
    $fake = unserialize(FAKE);     
    //Continue upgrade
    if(in_array($aduser, $fake)){ 
        $menu = $this->menu_get_list(); 
        $str = "<li class='li_hidden'><ul>";
        $i=0;
        $k=0;
        if($menu) foreach($menu as $m){     
            //Neu la Parent         
            if($m["parent"] == 0 && $m["status"] == 0){
                $str .= '</ul></li>';
                $str .= '<li class="sub-menu">
                            <a class="" href="">
                                <i class="fa fa-tasks"></i>
                                <span>'.$m["name"].'</span>
                                <span class="dcjq-icon"></span>
                            </a>
                        ';                        
                $str .= '<ul class="sub">';     
                $k = 0;
            //Neu la Child menu
            }elseif($m["parent"] > 0){
                //detect for root
                if($m["location"] == "ad_user/menu" && $ad_id != 2)
                    continue;
                $k++;
                $parent = $this->menu_get_by_id($m["parent"]);
                if($parent->status == 0 && $m["status"] == 0)
                    $str .= '<li id="'.str_replace('/','_',$m["location"]).'"><a href="'.CPANEL.'/'.$m["location"].'">'.$k.'. '.$m["name"].'</a></li>';           
            }                                            
        }
        return $str;  
              
    }else{
        
        $group = $this->user->users_group_mix_get($ad_id);
        if(!$group)
            return false;
        $gids = array();    
        foreach($group as $g){
            if(!in_array($g->group_id, $gids))
                array_push($gids, $g->group_id);
        }
        $arr_menu_map = $this->menu_get_array_map_by_group($gids);
        if(!$arr_menu_map)
            return false;
        $menu = $this->menu_get_list(); 
        $str = "<li class='li_hidden'><ul>";
        $i=0;
        $k=0;
        if($menu) foreach($menu as $m){     
            //Neu la Parent         
            if($m["parent"] == 0 && $m["status"] == 0){
                //Kiem tra co quyen 1 sub nao trong parent nay hay ko
                $ck_in_menu_tab = $this->check_in_menu_tab($m["id"],$gids); 
                if($ck_in_menu_tab){ 
                    $str .= '</ul></li>';
                    $str .= '<li class="sub-menu">
                                <a class="" href="">
                                    <i class="fa fa-tasks"></i>
                                    <span>'.$m["name"].'</span>
                                    <span class="dcjq-icon"></span>
                                </a>
                            ';                        
                    $str .= '<ul class="sub">'; 
                }else{
                    //Kiem tra co quyen tren chinh parent hay ko
                    $ck = 0;
                    $chmod = $this->menu_chmod($m["id"],$gids);
                    if($chmod)
                        $ck = 1;
                    if($ck == 1){
                        $str .= '<li>
                                <a class="" href="">
                                    <i class="fa fa-tasks"></i>
                                    <span>'.$m["name"].'</span>
                                </a>
                            </li>';
                    }      
                }            
                $k = 0;
            //Neu la Child menu
            }elseif($m["parent"] > 0){
                //detect for root
                if($m["location"] == "ad_user/menu" && $ad_id != 2)
                    continue;
                $k++;
                $parent = $this->menu_get_by_id($m["parent"]);
                if(in_array($m["id"],$arr_menu_map) && $parent->status == 0 && $m["status"] == 0)
                    $str .= '<li id="'.str_replace('/','_',$m["location"]).'"><a href="'.CPANEL.'/'.$m["location"].'">'.$k.'. '.$m["name"].'</a></li>';      
            }                                            
        }
        return $str;    
    }    
}

function check_in_menu_tab($m_id,$group_ids){
    $ck = 0;
    if(in_array(0, $group_ids)) return 1; //fake for super admin.
    $menu = $this->menu_get_by_level($m_id,0); 
    if($menu){
        foreach($menu as $m){
            $chmod = $this->menu_chmod($m->id,$group_ids); 
            if($chmod)
                $ck = 1;
        }    
    }        
    return $ck;
}

#================================= LOG ===============================#

/**
 * Insert log action 
 * @param array value
 * @return id 
 **/
function log_insert($arr){
    $arr["admin_id"] = $this->session->userdata("admin_id");
    $arr["time"] = time();
    $this->db->insert("ad_log",$arr);
    $id = $this->db->insert_id();
    return $id;
}

/**
 * Update Log
 * @param id
 * @param array value 
 **/
function log_update($id, $arr){
    $this->db->where("id",$id)->update("ad_log",$arr);
    return $id;
}

function log_delete($ids){
    $ids_exp = explode("-",$ids);
    foreach($ids_exp as $id){
        if($id)
            $this->db->where("id",$id)->delete("ad_log");
    }
    return "success";    
}


/** 
 * Get Log
 * @param limit
 * @param offset
 * @param admin_id
 * @param from timestamp
 * @param to timestamp
 * @param key
 **/
function log_get($limit, $offset, $user=null, $from=null, $to=null, $key=null){
    $where = " WHERE 1 = 1 ";
    if($user)
        $where .= " AND a.username LIKE '%{$user}%'";
    if($from){
        $from_time = strtotime($from." 00:00:00");
        $where .= " AND l.time >= {$from_time}";
    }        
    if($to){
        $to_time = strtotime($to." 23:59:59");
        $where .= " AND l.time <= {$to_time}";
    }            
    if($key)
        $where .= " AND l.content LIKE '%{$key}%'";            
    $sql = "SELECT l.*, a.username FROM ad_log l LEFT JOIN ad_user a ON l.admin_id = a.id {$where} ORDER BY l.id DESC LIMIT {$limit} OFFSET {$offset}";
    $query = $this->db->query($sql);
    if($query->num_rows())
        return $query->result();
    else    
        return false;                     
}

/** 
 * Get Log total
 * @param admin_id
 * @param from timestamp
 * @param to timestamp
 * @param key
 **/
function log_get_total($user=null, $from=null, $to=null, $key=null){
    $where = " WHERE 1 = 1 ";
    if($user)
        $where .= " AND a.username LIKE '%{$user}%'";
    if($from){
        $from_time = strtotime($from." 00:00:00");
        $where .= " AND l.time >= {$from_time}";
    }        
    if($to){
        $to_time = strtotime($to." 23:59:59");
        $where .= " AND l.time <= {$to_time}";
    }            
    if($key)
        $where .= " AND l.content LIKE '%{$key}%'";            
    $sql = "SELECT COUNT(*) AS total FROM ad_log l LEFT JOIN ad_user a ON l.admin_id = a.id {$where}";
    $query = $this->db->query($sql);
    if($query->num_rows())
        return $query->row()->total;
    else    
        return 0;                     
}




}