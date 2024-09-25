<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MY_AdController {

function __construct(){
    parent::__construct();
    $this->load->model("common_model","mod");
    $this->load->model("user_model","user");
}

function category($action="view"){
    $data["action"] = "cat_".$action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":
            $rows = $this->mod->news_cat_get(0);
            if($rows) foreach($rows as $r){
                $tam = objectToArray($r);
                $sub = $this->mod->news_cat_get($r->id);
                if($sub)
                    $tam["sub"] = objectToArray($sub);
                $data["rows"][] = $tam;
                unset($tam);        
            }            
        break;

        case "addedit":
            if($chmod < 777)
                show_404_ad();
            if($this->input->post("name")){ 
                $id = $this->input->post("id");
                $arr["name"] = $this->input->post("name");
                $arr["z_index"] = $this->input->post("z_index");
                $arr["seo_title"] = $this->input->post("seo_title");
                $arr["seo_desc"] = $this->input->post("seo_desc");
                $arr["is_service"] = $this->input->post("is_service");
                if(isset($_POST["state"]))
                    $arr["state"] = 1;
                else
                    $arr["state"] = 0; 
                $parent = $this->input->post("parent");
                if($id != $parent)
                    $arr["parent"] = $parent;
                $slug = string_2_slug($this->input->post("slug"));
                if($slug == "")
                    $slug = string_2_slug($this->input->post("name"));
                $arr["slug"] = $slug;
                $rs = $this->mod->news_cat_update($id, $arr);
                redirect(XADMIN."/news/category");
            }
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $cat = $this->mod->news_cat_get_by_id($id);
                if($cat)
                    $data["row"] = $cat;                  
            }
            //Category parent
            $parent = $this->mod->news_cat_get(0);
            if($parent)
                $data["parent"] = $parent;  
            $max = $this->mod->news_cat_get_max();
            $data["max"] = $max;
        break;

        case "delete":
            $id = $this->input->post("id");
            $this->mod->news_cat_delete($id);
            echo "success";
            exit();
        break;
        
        case "switch_state":
            $id = $this->input->post("id");
            $state = 0;
            $news = $this->mod->news_cat_get_by_id($id);
            if($news->state == 0)
                $state = 1;
            $this->mod->news_cat_update($id, array("state"=>$state));
            echo "success";
            exit();
        break;
        
    }
    $this->temp->viewa("news_view",$data);
}


function manage($action="view"){
    $data["action"] = $action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":
            /** ------------ Pagination --------- **/
            $cat_id = $data["cat_id"] = isset($_GET["cat_id"])?$_GET["cat_id"]:0;
            $state = $data["state"] = isset($_GET["state"])?$_GET["state"]:-1;
            $hot = $data["hot"] = isset($_GET["hot"])?$_GET["hot"]:-1;            
            $title = $data["title"] = isset($_GET["title"])?urldecode($_GET["title"]):null;
            $offset = 0;
            $limit = 20;    
            $total = $this->mod->news_get_total($cat_id, $state, $hot, $title); 
            $this->load->library("xpagination");
            $this->xpagination->total = $total;
            $this->xpagination->_link = site_url(XADMIN."/news/manage/view?cat_id={$cat_id}&state={$state}&hot={$hot}&title={$title}");
            $this->xpagination->itemsPerPage = $limit;
            $this->xpagination->paginate();
            $offset = ($this->xpagination->currentPage-1)*$limit;
            $pagination  = "";
            if($total > $limit)
                $pagination = $this->xpagination->pageNumbers();
            $data["pagination"] = $pagination;  
            $rows = $this->mod->news_get($cat_id, $state, $hot, $title, $limit, $offset); 
            if($rows)
                $data["rows"] = $rows;            
            //category
            $category = $this->mod->news_cat_get(0);
            if($category) foreach($category as $r){
                $tam = objectToArray($r);
                $sub = $this->mod->news_cat_get($r->id);
                if($sub){
                    foreach($sub as $s){      
                        $tam["sub"][] = objectToArray($s);    
                    }
                }                    
                $data["category"][] = $tam;
                unset($tam);        
            }   
        break;

        case "addedit":
            if($chmod < 777)
                show_404_ad();
            if($this->input->post("ispost")){
                $arr["title"] = $this->input->post("title");
                $arr["caption"] = $this->input->post("caption");
                $arr["content"] = $this->input->post("content");
                $arr["cat_id"] = $this->input->post("cat_id");
                $arr["seo_title"] = $this->input->post("seo_title");
                $arr["seo_desc"] = $this->input->post("seo_desc");
                $slug = string_2_slug($this->input->post("slug"));
                if($slug == "")
                    $slug = string_2_slug($this->input->post("title"));
                $arr["slug"] = $slug;
                $id = $this->input->post("id"); 
                if($id == 0){
                    $arr["time_create"] = time();
                    $arr["ad_id"] = $this->session->userdata("admin_id");
                }
                if(isset($_POST["state"]))
                    $arr["state"] = 1;
                else
                    $arr["state"] = 0;
                if(isset($_POST["hot"]))
                    $arr["hot"] = 1;
                else
                    $arr["hot"] = 0;    
                /** Thumb **/    
                $path = "uploads/news";
                if(!file_exists($path))
                    mkdir($path);
                if(!file_exists($path."/thumb"))
                    mkdir($path."/thumb");
                if($_FILES["image"]["name"] != null){
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size']	= '10240'; //10M
                    $config['file_name'] = time();
                    $this->load->library('upload', $config);
                    $this->load->library('image_lib');
                    if($this->upload->do_upload('image')){
                        $img = $this->upload->data();
                        $arr["thumb"] = $img['file_name'];
                        #-- Create thumbnail
                        $config['image_library'] = 'gd2';
                        $config['source_image']	= $path."/".$img['file_name'];
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['thumb_marker'] = "";
                        $config['width']	 = 350;
                        $config['height']	= 220;
                        $config['new_image'] = $path."/thumb/".$img['file_name'];
                        $this->image_lib->initialize($config);
                        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                    } else {print_r($this->upload->display_errors());}

                    if($id > 0){
                        $old = $this->mod->news_get_by_id($id);
                        if(file_exists("uploads/news/".$old->thumb))
                            unlink("uploads/news/".$old->thumb);
                        if(file_exists("uploads/news/thumb/".$old->thumb))
                            unlink("uploads/news/thumb/".$old->thumb);
                    }
                }
                $rs = $this->mod->news_update($id, $arr);
                redirect(XADMIN."/news/manage");
            }
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $row = $this->mod->news_get_by_id($id);
                if($row)
                    $data["row"] = $row;
            }
            //category
            $category = $this->mod->news_cat_get(0);
            if($category) foreach($category as $r){
                $tam = objectToArray($r);
                $sub = $this->mod->news_cat_get($r->id);
                if($sub){
                    foreach($sub as $s){    
                        $tam["sub"][] = objectToArray($s);    
                    }
                }                    
                $data["category"][] = $tam;
                unset($tam);        
            }    
        break;

        case "delete":
            $id = $this->input->post("id");
            $this->mod->news_delete($id);
            echo "success";
            exit();
        break;

        case "switch_state":
            $id = $this->input->post("id");
            $state = 0;
            $news = $this->mod->news_get_by_id($id);
            if($news->state == 0)
                $state = 1;
            $this->mod->news_update($id, array("state"=>$state));
            echo "success";
            exit();
        break;
    }
    $data["seo_title"] = "Quản lý tin tức";
    $this->temp->viewa("news_view",$data);
}



function vanban($action="view"){
    $data["action"] = $action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":
            $offset = 0;
            $limit = 20;    
            $total = $this->mod->vanban_get_total(); 
            $this->load->library("xpagination");
            $this->xpagination->total = $total;
            $this->xpagination->_link = site_url(XADMIN."/news/vanban/view");
            $this->xpagination->itemsPerPage = $limit;
            $this->xpagination->paginate();
            $offset = ($this->xpagination->currentPage-1)*$limit;
            $pagination  = "";
            if($total > $limit)
                $pagination = $this->xpagination->pageNumbers();
            $data["pagination"] = $pagination;  
            $rows = $this->mod->vanban_get($limit, $offset); 
            if($rows)
                $data["rows"] = $rows;  
        break;

        case "addedit": 
            if($chmod < 777)
                show_404_ad();
            if($this->input->post("ispost")){
                $id = $this->input->post("id");
                $arr["name"] = $this->input->post("name");
                $arr["create_time"] = time();
                if($id == 0)
                    $arr["ad_id"] = $this->session->userdata("admin_id"); 
                //File
                $path = "uploads/vanban";
                if(!file_exists($path))
                    mkdir($path);
                if($_FILES["file"]["name"] != null){
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = '*';
                    $config['max_size']	= '10240';
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload('file')){
                        $img = $this->upload->data();
                        $arr["file"] = $img['file_name'];
                    } else {print_r($this->upload->display_errors());}

                    if($id > 0){
                        $old = $this->mod->vanban_get_by_id($id);
                        if(file_exists("uploads/vanban/".$old->file))
                            unlink("uploads/vanban/".$old->file);
                    }
                }
                $rs = $this->mod->vanban_update($id, $arr);
                redirect(XADMIN."/news/vanban");
            }
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $row = $this->mod->vanban_get_by_id($id);
                if($row)
                    $data["row"] = $row;
            }
        break;

        case "delete":
            $id = $this->input->post("id");
            $this->mod->vanban_delete($id);
            echo "success";
            exit();
        break;

    }
    $this->temp->viewa("vanban_view",$data);
}


}