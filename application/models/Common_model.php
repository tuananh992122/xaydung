<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Ho_Chi_Minh');

class common_model extends MY_Model{

function __construct(){
    parent::__construct();
}


/**---------------------  CONFIG  ------------------- **/

/**
 * Get config
 * @param array ids
 **/
function config_get($ids){
    $sql = "SELECT * FROM tb_config WHERE id IN (".implode(",",$ids).")";
    if(count($ids) > 1)
        $rows = $this->getRows($sql);
    else
        $rows = $this->getRow($sql);
    return $rows;
}

function config_update($id, $arr){
    return $this->setUpdate("tb_config", $id, $arr);
}

/** ----------------------- SLUG -------------------------- **/

function slug_get_by_slug($slug){
    $sql = "SELECT * FROM tb_slug WHERE slug = '{$slug}'";
    return $this->getRow($sql);
}

/**
 * @param slug
 * @param controller
 * @param function
 * @param param
 **/
function slug_insert($slug,$controller,$function,$param){
    $arr["slug"] = string_2_slug($slug);
    $arr["controller"] = $controller;
    $arr["function"] = $function;
    $arr["param"] = $param;
    return $this->setUpdate("tb_slug",0,$arr);
}

/**
 * @param slug
 * @param controller
 * @param function
 * @param param
 **/
function slug_update($slug, $controller, $function, $param){
    $slug = string_2_slug($slug);
    $data_slug = $this->slug_get_by_slug($slug);
    $slug_id = 0;
    if($data_slug)
        $slug_id = $data_slug->id;
    $arr["slug"] = $slug;
    $arr["controller"] = $controller;
    $arr["function"] = $function;
    $arr["param"] = $param;
    return $this->setUpdate("tb_slug",$slug_id,$arr);
}

function slug_delete($slug){
    $this->db->query("DELETE FROM tb_slug WHERE slug = '{$slug}'");
}


#----------------------- CONTACT -------------------------#

function contact_update($id, $arr){
    return $this->setUpdate("tb_contact", $id, $arr);
}

function contact_get($limit=30, $offset=0, $read=-1){
    $where = " WHERE 1 = 1";
    if($read >= 0)
        $where .= " AND is_read = ".$read;
    $sql = "SELECT * FROM tb_contact {$where} ORDER BY id DESC LIMIT {$limit} OFFSET {$offset}";
    return $this->getRows($sql);
}

function contact_get_total($read=-1){
    $where = " WHERE 1 = 1";
    if($read >= 0)
        $where .= " AND is_read = ".$read;
    $sql = "SELECT COUNT(*) AS total FROM tb_contact {$where}";
    $rs = $this->getRow($sql);
    if($rs)
        return $rs->total;
    else
        return 0;
}

function contact_get_by_id($id){
    $sql = "SELECT * FROM tb_contact WHERE id = {$id}";
    return $this->getRow($sql);
}

function contact_delete($id){
    $this->db->where("id",$id)->delete("tb_contact");
}

/**---------------------  NEWS  ------------------- **/

/**
 * @param parent
 * @param state
 **/
function news_cat_get($parent=-1,$state=-1,$service = -1, $is_menu = -1){
    $where = "WHERE 1 = 1";
    if($parent >= 0)
        $where .= " AND parent = ".$parent;
    if($state >= 0)
        $where .= " AND state = ".$state;
    if($service > 0)
        $where .= " AND is_service = ".$service;
    if($is_menu > -1)
        $where .= " AND is_menu = ".$is_menu;
    $sql = "SELECT * FROM tb_news_cat {$where} ORDER BY z_index ASC";
    return $this->getRows($sql);
}

function news_cat_update($id, $arr){
    return $this->setUpdate("tb_news_cat",$id, $arr);
}

function news_cat_get_by_id($id){
    $sql = "SELECT * FROM tb_news_cat WHERE id = ".$id;
    return $this->getRow($sql);
}

function news_cat_get_by_slug($slug){
    $sql = "SELECT * FROM tb_news_cat WHERE slug = '{$slug}'";
    return $this->getRow($sql);
}

function news_cat_get_max(){
    $sql = "SELECT * FROM tb_news_cat ORDER BY z_index DESC LIMIT 1 OFFSET 0";
    $rs = $this->getRow($sql);
    if($rs)
        return $rs->z_index + 1;
    else
        return 1;
}

function news_cat_delete($id){
    $this->db->query("DELETE FROM tb_news_cat WHERE id = ".$id);
}


/**
 * Get all sub of parents product category 
 * @param cat_id
 * @return array cat_id
 **/
function news_cat_get_all_sub($cat_id){
    $tam = array($cat_id);
    $cats = $this->news_cat_get($cat_id);
    if($cats) foreach($cats as $c){
        $tam[] = $c->id;
        //Sub1
        $sub1 = $this->news_cat_get($c->id); 
        if($sub1) foreach($sub1 as $s1){            
            $tam[] = $s1->id;
            //Sub2
            $sub2 = $this->news_cat_get($s1->id);
            if($sub2) foreach($sub2 as $s2){
                $tam[] = $s2->id;                      
                //Sub3
                $sub3 = $this->news_cat_get($s2->id);
                if($sub3) foreach($sub3 as $s3){
                    $tam[] = $s3->id;
                    //Sub4
                    $sub4 = $this->news_cat_get($s3->id);
                    if($sub4) foreach($sub4 as $s4){
                        $tam[] = $s4->id;
                    }                            
                }
            }                    
        }                                                
    } 
    return $tam;
}

/**
 * News get
 * @param cat_id
 * @param state
 * @param hot
 * @param title 
 * @param limit
 * @param offset
 * @param order_by z_index | id
 **/
function news_get($cat_id=0, $state=-1, $hot=-1, $title=null, $limit=20, $offset=0, $order_by="id"){
    $where = "WHERE 1 = 1";
    if($title)
        $where .= " AND n.title LIKE '%{$title}%'";
    if($state >= 0)
        $where .= " AND n.state = ".$state;
    if($cat_id)
        $where .= " AND n.cat_id = ".$cat_id;
    if($hot >= 0)
        $where .= " AND n.hot = 1";    
    
    $ext = "";
    if($limit)
        $ext = "lIMIT {$limit} OFFSET {$offset}";        
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_news n LEFT JOIN tb_news_cat c ON n.cat_id = c.id
            {$where} ORDER BY n.{$order_by} DESC {$ext}";
    return $this->getRows($sql);
}

/**
 * @param cat_id
 * @param state
 * @param hot
 * @param title 
 **/
function news_get_total($cat_id=0, $state=-1, $hot=-1, $title=null){
    $where = "WHERE 1 = 1";
    if($title)
        $where .= " AND title LIKE '%{$title}%'";
    if($state >= 0)
        $where .= " AND state = ".$state;
    if($hot >= 0)
        $where .= " AND hot = ".$hot;
    if($cat_id)
        $where .= " AND cat_id = ".$cat_id;
    $sql = "SELECT COUNT(*) AS total
            FROM tb_news 
            {$where}";
    $rs = $this->getRow($sql);
    if($rs)
        return $rs->total;
    return 0;
}

/**
 * @param cat_id
 * @param state
 **/
function news_get_total_in_tree_cat($cat_id, $state=-1){
    $cat_ids = $this->news_cat_get_all_sub($cat_id);
    $where = " WHERE n.cat_id IN (".implode(",",$cat_ids).") ";
    if($state >= 0)
        $where .= " AND n.state = {$state}";
    $sql = "SELECT COUNT(*) AS total
            FROM tb_news n LEFT JOIN tb_news_cat c ON n.cat_id = c.id
            {$where}";
    $row = $this->getRow($sql);
    if($row)
        return $row->total;            
    else
        return 0;
}

/**
 * @param cat_id
 * @param state
 * @param limit
 * @param offset 
 **/
function news_get_in_tree_cat($cat_id, $state=-1, $limit, $offset){
    $cat_ids = $this->news_cat_get_all_sub($cat_id);
    $where = " WHERE n.cat_id IN (".implode(",",$cat_ids).") ";
    if($state >= 0)
        $where .= " AND n.state = {$state}";
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_news n LEFT JOIN tb_news_cat c ON n.cat_id = c.id
            {$where} ORDER BY n.id DESC LIMIT {$limit} OFFSET {$offset}";
    return $this->getRows($sql);
}

function news_get_by_id($id){
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_news n LEFT JOIN tb_news_cat c ON n.cat_id = c.id
            WHERE n.id = {$id}";
    return $this->getRow($sql);
}

function news_get_by_slug($slug){
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_news n LEFT JOIN tb_news_cat c ON n.cat_id = c.id
            WHERE n.slug = '{$slug}' ";
    return $this->getRow($sql);
}

function news_get_other($cat_id = 0, $id = 0, $limit = 0){
    $where = "WHERE 1 = 1 AND n.state = 1 ";
    if($id >= 0)
        $where .= " AND n.id != ".$id;
    if($cat_id)
        $where .= " AND n.cat_id = ".$cat_id; 
    
    $ext = "";
    if($limit)
        $ext = "lIMIT {$limit} ";        
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_news n LEFT JOIN tb_news_cat c ON n.cat_id = c.id
            {$where} ORDER BY n.id DESC {$ext}";
    return $this->getRows($sql);
}

function news_update($id, $arr){
    return $this->setUpdate("tb_news", $id, $arr);
}

function news_delete($id){
    $news = $this->news_get_by_id($id);
    $this->db->where("id",$id)->delete("tb_news");
    $this->db->where("slug",$news->slug)->delete("tb_slug");
    if($news->thumb){
        $path = "uploads/news/";
        if(file_exists($path.$news->thumb))
            unlink($path.$news->thumb);
        if(file_exists($path."thumb/".$news->thumb))
            unlink($path."thumb/".$news->thumb);
    }
}

/**---------------------  CATEGORY  ------------------- **/

/**
 * Category get
 * @param parent -1: all
 * @param state
 * @param is_home 
 * @param is_menu_left
 **/
function category_get($parent=-1, $state=-1, $is_home=-1, $is_menu=-1){
    $where = "WHERE 1 = 1";
    if($parent >= 0)
        $where .= " AND parent = {$parent}";
    if($state >= 0)
        $where .= " AND state = ".$state;    
    if($is_home >= 0)
        $where .= " AND is_home = ".$is_home; 
    if($is_menu >= 0)
        $where .= " AND is_menu = ".$is_menu; 
    $sql = "SELECT * FROM tb_category {$where} ORDER BY z_index ASC";
    return $this->getRows($sql);
}

function category_get_by_id($id){
    $sql = "SELECT * FROM tb_category WHERE id = {$id}";
    return $this->getRow($sql);
}

function category_get_by_slug($slug){
    $sql = "SELECT * FROM tb_category WHERE slug = '{$slug}' ORDER BY z_index ASC LIMIT 1";
    return $this->getRow($sql);
}

function category_update($id, $arr){
    return $this->setUpdate("tb_category", $id, $arr);
}

function category_delete($id){
    $cat = $this->category_get_by_id($id);
    $ck_sub = $this->category_get($id);
    if($ck_sub)
        return "has_sub";
    else{
        $this->db->where("id",$id)->delete("tb_category");
        if($cat->thumb){
            $path = "uploads/category/".$cat->thumb;
            if(file_exists($path))
                unlink($path);
        }
        $this->db->query("DELETE FROM tb_slug WHERE slug = '{$cat->slug}'");
        return "success";
    }
}

/**
 * Get distinct cat_id in tb_product 
 **/
function category_has_product(){
    $sql = "SELECT DISTINCT cat_id, c.name AS cname 
            FROM tb_product p LEFT JOIN tb_category c ON p.cat_id = c.id";
    return $this->getRows($sql);
    
}

/**
 * Get all sub of parents root category 
 * @param cat_id
 * @return array cat_id
 **/
function category_get_all_sub($cat_id){
    $tam = array($cat_id);
    $cats = $this->category_get($cat_id);
    if($cats) foreach($cats as $c){
        $tam[] = $c->id;
        //Sub1
        $sub1 = $this->category_get($c->id); 
        if($sub1) foreach($sub1 as $s1){            
            $tam[] = $s1->id;
            //Sub2
            $sub2 = $this->category_get($s1->id);
            if($sub2) foreach($sub2 as $s2){
                $tam[] = $s2->id;                      
                //Sub3
                $sub3 = $this->category_get($s2->id);
                if($sub3) foreach($sub3 as $s3){
                    $tam[] = $s3->id;
                    //Sub4
                    $sub4 = $this->category_get($s3->id);
                    if($sub4) foreach($sub4 as $s4){
                        $tam[] = $s4->id;
                    }                            
                }
            }                    
        }                                                
    } 
    return $tam;
}

function category_get_top_parent($id){
    //Tam tinh: max = 3 cap
    $cat = $this->category_get_by_id($id);
    if($cat->parent == 0)
        return $id;
    else{
        $parent = $this->category_get_by_id($cat->parent);
        if($parent->parent == 0)
            return $parent->id;
        else{
            $next_parent = $this->category_get_by_id($parent->parent);
            if($next_parent->parent == 0)
                return $next_parent->id;
            else
                return 0;                
        }    
    }        
}

function category_parse_tree(){    
    $cats = $this->category_get(0,1,-1,1); 
    if($cats) foreach($cats as $s0){
        //$tam0 = objectToArray($c);
        //Sub1
        $sub1 = $this->category_get($s0->id,1,-1,1);
        if($sub1) foreach($sub1 as $s1){          
            //$tam1[] = objectToArray($s1);
            //Sub2
            $sub2 = $this->category_get($s1->id,1,-1,1);
            if($sub2) foreach($sub2 as $s2){                
                //$tam2[] = objectToArray($s2);
                //Sub3
                $sub3 = $this->category_get($s2->id,1,-1,1);
                if($sub3) foreach($sub3 as $s3){
                    //$tam3[] = objectToArray($s3);
                    //Sub4
                    $sub4 = $this->category_get($s3->id,1,-1,1);
                    if($sub4) foreach($sub4 as $s4){
                        $tam4[] = objectToArray($s4);
                    }
                    if(isset($tam4)){
                        $s3->sub = $tam4;
                        //$tam3["sub"] = $tam4;
                        unset($tam4);
                    }    
                    $tam3[] = objectToArray($s3);                 
                }
                if(isset($tam3)){
                    $s2->sub = $tam3;
                    //$tam2["sub"] = $tam3;
                    unset($tam3);
                }
                $tam2[] = objectToArray($s2);         
            }
            if(isset($tam2)){
                $s1->sub = $tam2;
                //$tam1["sub"] = $tam2;
                unset($tam2);
            }
            $tam1[] = objectToArray($s1);    
        }
        if(isset($tam1)){
            $s0->sub = $tam1;
            //$tam0["sub"] = $tam1;
            unset($tam1);
        }           
        $tam0[] = objectToArray($s0);         
        $tam[] = $tam0;  
        unset($tam0);                      
    } 
    //echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
    //printr($tam); exit();
    return $tam;
}

function category_parse_breadcrumb($id){
    $current = $this->category_get_by_id($id);
    if(!$current)
        return false;
    $arr = array();
    //current
    $tam = array("id"=>$id, "slug"=>$current->slug, "name"=>$current->name);
    array_unshift($arr, $tam);    
    if($current->parent == 0)        
        return $arr;
    //parent 1
    $parent_1 = $this->category_get_by_id($current->parent);
    $tam = array("id"=>$parent_1->id, "slug"=>$parent_1->slug, "name"=>$parent_1->name);
    array_unshift($arr, $tam);
    if($parent_1->parent == 0)
        return $arr;
    //parent 2
    $parent_2 = $this->category_get_by_id($parent_1->parent);
    if($parent_2){
        $tam = array("id"=>$parent_2->id, "slug"=>$parent_2->slug, "name"=>$parent_2->name);
        array_unshift($arr, $tam);
        if($parent_2->parent == 0)
            return $arr;
    }    
    //parent 3
    $parent_3 = $this->category_get_by_id($parent_2->parent);
    if($parent_3){
        $tam = array("id"=>$parent_3->id, "slug"=>$parent_3->slug, "name"=>$parent_3->name);
        array_unshift($arr, $tam);
        if($parent_3->parent == 0)
            return $arr;    
    }    
    return;
}

/**---------------------  HOME SLIDE  ------------------- **/

function hslide_get($limit=0, $offset=0){
    $ext = "";
    if($limit>0){
        $ext .= " LIMIT {$limit} OFFSET {$offset}";
    }
    $sql = "SELECT * FROM tb_hslide ORDER BY z_index DESC {$ext}";
    $rows = $this->getRows($sql);
    return $rows;
}

function hslide_update($id, $arr){
    return $this->setUpdate("tb_hslide", $id, $arr);
}


function hslide_get_by_id($id){
    $sql = "SELECT * FROM tb_hslide WHERE id = {$id} limit 1";
    $row = $this->getRow($sql);
    return $row;
}

function hslide_get_total(){
    $data = $this->db->count_all('tb_hslide');
    return $data;
}


function hslide_delete($id){
    $old = $this->hslide_get_by_id($id);
    if($old && $old->image){
        $path = "uploads/hslide/".$old->id;
        if(file_exists($path."/".$old->image))
            unlink($path."/".$old->image);
    }
    $this->db->query("DELETE FROM tb_hslide WHERE id = {$id}");
}

/**---------------------  PRODUCT  ------------------- **/

/**
 * @param parent
 * @param is_active
 **/
function product_cat_get($parent=-1,$is_active=-1){
    $where = "WHERE 1 = 1";
    if($parent >= 0)
        $where .= " AND parent = ".$parent;
    if($is_active >= 0)
        $where .= " AND is_active = ".$is_active;
    $sql = "SELECT * FROM tb_product_cat {$where} ORDER BY z_index ASC";
    return $this->getRows($sql);
}

function product_cat_update($id, $arr){
    return $this->setUpdate("tb_product_cat",$id, $arr);
}

function product_cat_get_by_id($id){
    $sql = "SELECT * FROM tb_product_cat WHERE id = ".$id;
    return $this->getRow($sql);
}

function product_cat_get_by_slug($slug){
    $sql = "SELECT * FROM tb_product_cat WHERE slug = '{$slug}'";
    return $this->getRow($sql);
}

function product_cat_get_max(){
    $sql = "SELECT * FROM tb_product_cat ORDER BY z_index DESC LIMIT 1 OFFSET 0";
    $rs = $this->getRow($sql);
    if($rs)
        return $rs->z_index + 1;
    else
        return 1;
}

function product_cat_delete($id){
    $this->db->query("DELETE FROM tb_product_cat WHERE id = ".$id);
}


/**
 * product get
 * @param cat_id
 * @param is_active
 * @param hot
 * @param title 
 * @param limit
 * @param offset
 * @param order_by z_index | id
 **/
function product_get($product_cat=0, $is_active=-1, $hot=-1, $name=null, $limit=20, $offset=0, $order_by="id", $is_slide = 0){
    $where = "WHERE 1 = 1";
    if($name)
        $where .= " AND n.name LIKE '%{$name}%'";
    if($is_active >= 0)
        $where .= " AND n.is_active = ".$is_active;
    if($product_cat)
        $where .= " AND n.product_cat = ".$product_cat;
    if($hot >= 0)
        $where .= " AND n.hot = {$hot}";    
    if($is_slide > 0)
        $where .= " AND n.is_slide = {$is_slide}";  
    
    $ext = "";
    if($limit)
        $ext = "lIMIT {$limit} OFFSET {$offset}";        
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_product n LEFT JOIN tb_product_cat c ON n.product_cat = c.id
            {$where} ORDER BY n.{$order_by} DESC {$ext}";
    return $this->getRows($sql);
}

/**
 * @param cat_id
 * @param is_active
 * @param hot
 * @param title 
 **/
function product_get_total($product_cat=0, $is_active=-1, $hot=-1, $name=null){
    $where = "WHERE 1 = 1";
    if($name)
        $where .= " AND name LIKE '%{$name}%'";
    if($is_active >= 0)
        $where .= " AND is_active = ".$is_active;
    if($hot >= 0)
        $where .= " AND hot = ".$hot;
    if($product_cat)
        $where .= " AND product_cat = ".$product_cat;
    $sql = "SELECT COUNT(*) AS total
            FROM tb_product 
            {$where}";
    $rs = $this->getRow($sql);
    if($rs)
        return $rs->total;
    return 0;
}

/**
 * @param product_cat
 * @param is_active
 **/
function product_get_total_in_tree_cat($product_cat, $is_active=-1){
    $product_cats = $this->product_cat_get_all_sub($product_cat);
    $where = " WHERE n.product_cat IN (".implode(",",$product_cats).") ";
    if($is_active >= 0)
        $where .= " AND n.is_active = {$is_active}";
    $sql = "SELECT COUNT(*) AS total
            FROM tb_product n LEFT JOIN tb_product_cat c ON n.product_cat = c.id
            {$where}";
    $row = $this->getRow($sql);
    if($row)
        return $row->total;            
    else
        return 0;
}

/**
 * @param cat_id
 * @param is_active
 * @param limit
 * @param offset 
 **/
function product_get_in_tree_cat($product_cat, $is_active=-1, $limit, $offset){
    $product_cats = $this->product_cat_get_all_sub($product_cat);
    $where = " WHERE n.product_cat IN (".implode(",",$product_cats).") ";
    if($is_active >= 0)
        $where .= " AND n.is_active = {$is_active}";
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_product n LEFT JOIN tb_product_cat c ON n.product_cat = c.id
            {$where} ORDER BY n.id DESC LIMIT {$limit} OFFSET {$offset}";
    return $this->getRows($sql);
}

function product_get_by_id($id){
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_product n LEFT JOIN tb_product_cat c ON n.product_cat = c.id
            WHERE n.id = {$id}";
    return $this->getRow($sql);
}

function product_get_by_cat($cat_id = 0){
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_product n LEFT JOIN tb_product_cat c ON n.product_cat = c.id
            WHERE n.product_cat = {$cat_id} AND n.is_active = 1";
    return $this->getRows($sql);
}

function product_get_by_slug($slug,$is_active = 0){
    $where = '';
    if($is_active > 0)
        $where = " AND n.is_active = 1 ";
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_product n LEFT JOIN tb_product_cat c ON n.product_cat = c.id
            WHERE n.slug = '{$slug}' {$where} ";
    return $this->getRow($sql);
}

function product_update($id, $arr){
    return $this->setUpdate("tb_product", $id, $arr);
}

function product_delete($id){
    $product = $this->product_get_by_id($id);
    $this->db->where("id",$id)->delete("tb_product");
    $this->db->where("slug",$product->slug)->delete("tb_slug");
    if($product->thumb){
        $path = "uploads/product/";
        if(file_exists($path.$product->thumb))
            unlink($path.$product->thumb);
        if(file_exists($path."thumb/".$product->thumb))
            unlink($path."thumb/".$product->thumb);
    }
    if($product->slide){
        $path_slide = "uploads/product/slide/";
        if(file_exists($path_slide.$product->slide))
            unlink($path_slide.$product->slide);
        if(file_exists($path_slide."thumb/".$product->slide))
            unlink($path_slide."thumb/".$product->slide);
    }
}

function product_get_other($cat_id=0,$id=0,$limit=0){
    $sql = "SELECT n.*, c.name AS cname, c.slug AS cslug
            FROM tb_product n LEFT JOIN tb_product_cat c ON n.product_cat = c.id
            WHERE n.id != {$id} AND product_cat = {$cat_id}";
    return $this->getRows($sql);
}
/** ----------------- Gallery Product ------------------ **/

function product_gallery_get($product_id = 0){
    $where = " WHERE 1 = 1 ";
    if($product_id > 0)
        $where .= " AND product_id = ".$product_id;
    $sql = "SELECT * FROM tb_product_gallery {$where} ORDER BY id DESC";
    return $this->getRows($sql);
}


function product_gallery_get_by_id($id){
    $sql = "SELECT * FROM tb_product_gallery WHERE id = {$id}";
    $row = $this->getRow($sql);
    return $row;
}

function product_gallery_update($id, $arr){
    return $this->setUpdate("tb_product_gallery", $id, $arr);
}


function product_gallery_delete($id){
    $old = $this->product_gallery_get_by_id($id);
    if($old && $old->image){
        $path = "uploads/product/gallery/".$old->product_id;
        if(file_exists($path."/".$old->image)){
            unlink($path."/".$old->image);
            unlink($path."/thumb/".$old->image);
        }
    }
    $this->db->query("DELETE FROM tb_product_gallery WHERE id = {$id}");
}

/*----------------------- PRODUCT SOLD ---------------------------*/
function product_sold_get($product_id = 0, $limit=20, $offset=0){
    $where = "WHERE 1 = 1";
    if( $product_id > 0)
        $where .= " AND product_id = {$product_id}";
    
    $ext = "";
    if($limit)
        $ext = "lIMIT {$limit} OFFSET {$offset}";        
    $sql = "SELECT *
            FROM tb_product_sold
            {$where} ORDER BY id DESC {$ext}";
    return $this->getRows($sql);
}

/**
 * @param cat_id
 * @param is_active
 * @param hot
 * @param title 
 **/
function product_sold_get_total($product_id=0){
    $where = "WHERE 1 = 1";
    $where = "WHERE 1 = 1";
    if( $product_id > 0)
        $where .= " AND product_id = {$product_id}";
    $sql = "SELECT COUNT(*) AS total
            FROM tb_product_sold 
            {$where}";
    $rs = $this->getRow($sql);
    if($rs)
        return $rs->total;
    return 0;
}

function product_sold_get_by_id($id){
    $sql = "SELECT n.*, c.name AS product_name
            FROM tb_product_sold n LEFT JOIN tb_product c ON n.product_id = c.id
            WHERE n.id = {$id}";
    return $this->getRow($sql);
}

function product_sold_update($id, $arr){
    return $this->setUpdate("tb_product_sold", $id, $arr);
}

function product_sold_delete($id){
    $product_sold = $this->product_sold_get_by_id($id);
    $this->db->where("id",$id)->delete("tb_product_sold");
    if($product_sold->thumb){
        $path = "uploads/product/sold/";
        if(file_exists($path.$product_sold->thumb))
            unlink($path.$product_sold->thumb);
        
    }
}

function product_cat_get_menu($parent=-1,$is_active=-1){
    $where = "WHERE 1 = 1";
    
    if($parent >= 0)
        $where .= " AND parent = ".$parent;
    if($is_active >= 0)
        $where .= " AND is_active = ".$is_active;
    $select = " (SELECT COUNT(*) FROM tb_product WHERE tb_product.product_cat = tb_product_cat.id AND tb_product.is_active = 1) AS count_product ";
    $sql = "SELECT *, {$select} FROM tb_product_cat {$where} ORDER BY z_index ASC";
    return $this->getRows($sql);
}

/**---------------------  ORDER  ------------------- **/

function order_get($limit = 0, $offset=0){
    $ext = '';
    if($limit>0)
        $ext = " LIMIT {$limit} OFFSET {$offset} ";
    $sql = "SELECT * FROM tb_order ORDER BY id DESC {$ext}";
    return $this->getRows($sql);
}

function order_get_total(){
    $sql = "SELECT COUNT(*) as total FROM tb_order";
    $rs = $this->getRow($sql);
    if($rs)
        return $rs->total;
    return 0;
}

function order_update($id, $arr){
    return $this->setUpdate("tb_order",$id, $arr);
}

function order_get_by_id($id){
    $sql = "SELECT * FROM tb_order WHERE id = ".$id;
    return $this->getRow($sql);
}

function order_delete($id){
    $this->db->query("DELETE FROM tb_order WHERE id = ".$id);
}

/**---------------------  FEEDBACK  ------------------- **/

function feedback_get($limit=0, $offset=0){
    $ext = "";
    if($limit>0){
        $ext .= " LIMIT {$limit} OFFSET {$offset}";
    }
    $sql = "SELECT * FROM tb_feedback ORDER BY id DESC {$ext}";
    $rows = $this->getRows($sql);
    return $rows;
}

function feedback_update($id, $arr){
    return $this->setUpdate("tb_feedback", $id, $arr);
}


function feedback_get_by_id($id){
    $sql = "SELECT * FROM tb_feedback WHERE id = {$id} limit 1";
    $row = $this->getRow($sql);
    return $row;
}

function feedback_get_total(){
    $data = $this->db->count_all('tb_feedback');
    return $data;
}


function feedback_delete($id){
    $old = $this->feedback_get_by_id($id);
    if($old && $old->image){
        $path = "uploads/feedback/".$old->id;
        if(file_exists($path."/".$old->image))
            unlink($path."/".$old->image);
    }
    $this->db->query("DELETE FROM tb_feedback WHERE id = {$id}");
}

/**---------------------  brands  ------------------- **/

function brands_get($limit=0, $offset=0){
    $ext = "";
    if($limit>0){
        $ext .= " LIMIT {$limit} OFFSET {$offset}";
    }
    $sql = "SELECT * FROM tb_brands ORDER BY id DESC {$ext}";
    $rows = $this->getRows($sql);
    return $rows;
}

function brands_update($id, $arr){
    return $this->setUpdate("tb_brands", $id, $arr);
}


function brands_get_by_id($id){
    $sql = "SELECT * FROM tb_brands WHERE id = {$id} limit 1";
    $row = $this->getRow($sql);
    return $row;
}

function brands_get_total(){
    $data = $this->db->count_all('tb_brands');
    return $data;
}


function brands_delete($id){
    $old = $this->brands_get_by_id($id);
    if($old && $old->thumb){
        $path = "uploads/brands/".$old->id;
        if(file_exists($path."/".$old->thumb))
            unlink($path."/".$old->thumb);
    }
    $this->db->query("DELETE FROM tb_brands WHERE id = {$id}");
}

/**---------------------  Video  ------------------- **/

function video_get($limit=0, $offset=0){
    $ext = "";
    if($limit>0){
        $ext .= " LIMIT {$limit} OFFSET {$offset}";
    }
    $sql = "SELECT * FROM tb_video ORDER BY id DESC {$ext}";
    $rows = $this->getRows($sql);
    return $rows;
}

function video_update($id, $arr){
    return $this->setUpdate("tb_video", $id, $arr);
}

function video_delete($id){
    if($id == 0)
        return "false";
    $query = $this->db->where("id",$id)->delete("tb_video");
    if($query){
        return "success";
    }
    else
        return "false";            
}

function video_get_by_id($id){
    $sql = "SELECT * FROM tb_video WHERE id = {$id} limit 1";
    $row = $this->getRow($sql);
    return $row;
}

function video_get_total(){
    $data = $this->db->count_all('tb_video');
    return $data;
}

}