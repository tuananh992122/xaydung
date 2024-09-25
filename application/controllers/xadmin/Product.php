<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends MY_AdController{
    
    
function __construct(){
    parent::__construct();
    $this->load->model("common_model","mod");
}

function category($action="view"){
    $data["action"] = "cat_".$action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":
            $rows = $this->mod->product_cat_get(0);
            if($rows) foreach($rows as $r){
                $tam = objectToArray($r);
                $sub = $this->mod->product_cat_get($r->id);
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
                if(isset($_POST["is_active"]))
                    $arr["is_active"] = 1;
                else
                    $arr["is_active"] = 0; 
                $parent = $this->input->post("parent");
                if($id != $parent)
                    $arr["parent"] = $parent;
                else
                    $arr["parent"] = 0;
                $slug = string_2_slug($this->input->post("slug"));
                if($slug == "")
                    $slug = string_2_slug($this->input->post("name"));
                $arr["slug"] = $slug;
                $rs = $this->mod->product_cat_update($id, $arr);
                redirect(XADMIN."/product/category");
            }
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $cat = $this->mod->product_cat_get_by_id($id);
                if($cat)
                    $data["row"] = $cat;                  
            }
            //Category parent
            $parent = $this->mod->product_cat_get(0);
            if($parent)
                $data["parent"] = $parent;  
            $max = $this->mod->product_cat_get_max();
            $data["max"] = $max;
        break;

        case "delete":
            $id = $this->input->post("id");
            $this->mod->product_cat_delete($id);
            echo "success";
            exit();
        break;
        
        case "switch_state":
            $id = $this->input->post("id");
            $is_active = 0;
            $product = $this->mod->product_cat_get_by_id($id);
            if($product->is_active == 0)
                $is_active = 1;
            $this->mod->product_cat_update($id, array("is_active"=>$is_active));
            echo "success";
            exit();
        break;
        
    }
    $this->temp->viewa("product_view",$data);
}

function manage($action="view"){
    $data["action"] = $action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":
            /** ------------ Pagination --------- **/
            $product_cat = $data["product_cat"] = isset($_GET["product_cat"])?$_GET["product_cat"]:0;
            $is_active = $data["is_active"] = isset($_GET["is_active"])?$_GET["is_active"]:-1;
            $hot = $data["hot"] = isset($_GET["hot"])?$_GET["hot"]:-1;            
            $name = $data["name"] = isset($_GET["name"])?urldecode($_GET["name"]):null;
            $offset = 0;
            $limit = 20;    
            $total = $this->mod->product_get_total($product_cat, $is_active, $hot, $name); 
            $this->load->library("xpagination");
            $this->xpagination->total = $total;
            $this->xpagination->_link = site_url(XADMIN."/product/manage/view?product_cat={$product_cat}&is_active={$is_active}&hot={$hot}&name={$name}");
            $this->xpagination->itemsPerPage = $limit;
            $this->xpagination->paginate();
            $offset = ($this->xpagination->currentPage-1)*$limit;
            $pagination  = "";
            if($total > $limit)
                $pagination = $this->xpagination->pageNumbers();
            $data["pagination"] = $pagination;  
            $rows = $this->mod->product_get($product_cat, $is_active, $hot, $name, $limit, $offset); 
            if($rows)
                $data["rows"] = $rows;            
            //category
            $category = $this->mod->product_cat_get(0);
            if($category) foreach($category as $r){
                $tam = objectToArray($r);
                $sub = $this->mod->product_cat_get($r->id);
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

                $arr["name"] = $this->input->post("name");
                $arr["caption"] = $this->input->post("caption");
                $arr["content"] = $this->input->post("content");
                $arr["product_cat"] = $this->input->post("product_cat");
                $arr["price"] = str_replace(',','',$this->input->post("price"));
                $arr["link_home"] = $this->input->post("link_home");
                $arr["link_admin"] = $this->input->post("link_admin");
                $arr["seo_title"] = $this->input->post("seo_title");
                $arr["seo_desc"] = $this->input->post("seo_desc");
                $slug = string_2_slug($this->input->post("slug"));
                if($slug == "")
                    $slug = string_2_slug($this->input->post("name"));
                $arr["slug"] = $slug;
                $id = $this->input->post("id"); 
                if($id == 0){
                    $arr["time_create"] = time();
                }
                if(isset($_POST["is_active"]))
                    $arr["is_active"] = 1;
                else
                    $arr["is_active"] = 0;
                if(isset($_POST["hot"]))
                    $arr["hot"] = 1;
                else
                    $arr["hot"] = 0;  
                    
                if(isset($_POST["is_slide"])){
                    $arr["is_slide"] = 1;
                    //Slide
                    $path_slide = "uploads/product/slide";
                    if(!file_exists($path_slide))
                        mkdir($path_slide);
                    if(!file_exists($path_slide."/thumb"))
                        mkdir($path_slide."/thumb");
                    if($_FILES["slide"]["name"] != null){
                        $config['upload_path'] = $path_slide;
                        $config['allowed_types'] = 'gif|jpg|jpeg|png';
                        $config['max_size']	= '10240'; //10M
                        $config['file_name'] = time();
                        $this->load->library('upload', $config);
                        $this->load->library('image_lib');
                        if($this->upload->do_upload('slide')){
                            $img = $this->upload->data();
                            $arr["slide"] = $img['file_name'];
                            #-- Create thumbnail
                            $config['image_library'] = 'gd2';
                            $config['source_image']	= $path_slide."/".$img['file_name'];
                            $config['create_thumb'] = TRUE;
                            $config['maintain_ratio'] = TRUE;
                            $config['thumb_marker'] = "";
                            $config['width']	 = 350;
                            $config['height']	= 210;
                            $config['new_image'] = $path_slide."/thumb/".$img['file_name'];
                            $this->image_lib->initialize($config);
                            if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                        } else {print_r($this->upload->display_errors());}
                        if($id > 0){
                            $old = $this->mod->product_get_by_id($id);
                            if(file_exists("uploads/product/slide/".$old->slide))
                                unlink("uploads/product/slide/".$old->slide);
                            if(file_exists("uploads/product/slide/thumb/".$old->slide))
                                unlink("uploads/product/slide/thumb/".$old->slide);
                        }
                    }
                }
                else{
                    $arr["is_slide"] = 0; 
                    if($id > 0){
                        $old = $this->mod->product_get_by_id($id);
                        if(file_exists("uploads/product/slide/".$old->slide))
                            unlink("uploads/product/slide/".$old->slide);
                        if(file_exists("uploads/product/slide/thumb/".$old->slide))
                            unlink("uploads/product/slide/thumb/".$old->slide);
                        $arr["slide"] = null;
                    }
                } 
                /** Thumb **/    
                $path = "uploads/product";
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
                        $config['height']	= 210;
                        $config['new_image'] = $path."/thumb/".$img['file_name'];
                        $this->image_lib->initialize($config);
                        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                    } else {print_r($this->upload->display_errors());}
                    

                    if($id > 0){
                        $old = $this->mod->product_get_by_id($id);
                        if(file_exists("uploads/product/".$old->thumb))
                            unlink("uploads/product/".$old->thumb);
                        if(file_exists("uploads/product/thumb/".$old->thumb))
                            unlink("uploads/product/thumb/".$old->thumb);
                    }
                }
                
                $rs = $this->mod->product_update($id, $arr);
                redirect(XADMIN."/product/manage");
            }
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $row = $this->mod->product_get_by_id($id);
                if($row)
                    $data["row"] = $row;
            }
            //category
            $category = $this->mod->product_cat_get(0);
            if($category) foreach($category as $r){
                $tam = objectToArray($r);
                $sub = $this->mod->product_cat_get($r->id);
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
            $this->mod->product_delete($id);
            echo "success";
            exit();
        break;

        case "switch_state":
            $id = $this->input->post("id");
            $state = 0;
            $product = $this->mod->product_get_by_id($id);
            if($product->is_active == 0)
                $state = 1;
            $this->mod->product_update($id, array("is_active"=>$state));
            echo "success";
            exit();
        break;
    }
    $data["seo_title"] = "Quản lý sản phẩm";
    $this->temp->viewa("product_view",$data);
}

function order($action="view"){
    $data["action"] = "order_".$action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":           
            $limit = 30;
            $offset = 0;
            if($this->uri->segment(5))
                $offset = $this->uri->segment(5);
                  
            $rows = $this->mod->order_get($limit,$offset);
            if($rows)
                $data["rows"] = $rows;
            $total = $this->mod->order_get_total();
            #------------ PAGINATION -------------
            $config["uri_segment"] = 5;
            $config['base_url'] = CPANEL.'/product/order/view/';
            $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
            $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        
            $config['cur_tag_open'] = "<li><a class='current'>"; 
            $config['cur_tag_close'] = "</a></li>";
            $config['total_rows'] = $total;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);
            $data["pagi"] = $this->pagination->create_links();
            $data["offset"] = $offset;
            $data["total"]  = $total;
        break;
        
        case "detail":
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $order = $this->mod->order_get_by_id($id);
                if($order){
                    $arr["is_read"] = 1;
                    $this->mod->order_update($id,$arr);
                    $data["row"] = $order;
                    $product = $this->mod->product_get_by_id($order->product_id);
                    if($product)
                        $data['product'] = $product;
                }
                    
            }
        break;
        case "delete":
            $id = $this->input->post("id");
            $this->mod->order_delete($id);
            echo "success";
            exit();
        break;
    }    
    $this->temp->viewa("product_view",$data);
}

function gallery($action="view"){
    $data = null;
    $data["action"] = "gallery_".$action;
    switch($action){
        case "view":
            $product_id = $this->uri->segment(5);
            $ck = $this->mod->product_get_by_id($product_id);
            if(!$ck)
                show_404();
            #---- Gallery
            $gallery = $this->mod->product_gallery_get($product_id);
            if($gallery)
                $data["gallery"] = $gallery; 
            if($this->input->post("ispost")){
                $path = "uploads/product/gallery/".$product_id;
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
                        $arr["image"] = $img['file_name'];
                        #-- Create thumbnail
                        $config['image_library'] = 'gd2';
                        $config['source_image']	= $path."/".$img['file_name'];
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['thumb_marker'] = "";
                        $config['width']	 = 156;
                        $config['height']	= 97;
                        $config['new_image'] = $path."/thumb/".$img['file_name'];
                        $this->image_lib->initialize($config);
                        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                    } else {print_r($this->upload->display_errors());}
                }
                $arr["product_id"] = $product_id;
                $this->mod->product_gallery_update(0, $arr);
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
            
        break;
        case "delete":
            $id = $this->input->post("id");
            $this->mod->product_gallery_delete($id);
            exit("success");
        break;
    }    
    $this->temp->viewa("product_view",$data);        
}

function product_sold($action="view"){
    $data["action"] = "sold_".$action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    $product_id = 0;
    if($this->uri->segment(5))
        $product_id = $this->uri->segment(5);
    $ck = $this->mod->product_get_by_id($product_id);
    if(!$ck)
        show_404();
    $data["product_id"] = $product_id; 
    switch($action){
        case "view":
            /** ------------ Pagination --------- **/
            $offset = 0;
            $limit = 20;    
            $total = $this->mod->product_sold_get_total($product_id); 
            $this->load->library("xpagination");
            $this->xpagination->total = $total;
            $this->xpagination->_link = site_url(XADMIN."/product/product_sold/view/".$product_id);
            $this->xpagination->itemsPerPage = $limit;
            $this->xpagination->paginate();
            $offset = ($this->xpagination->currentPage-1)*$limit;
            $pagination  = "";
            if($total > $limit)
                $pagination = $this->xpagination->pageNumbers();
            $data["pagination"] = $pagination;  
            $rows = $this->mod->product_sold_get($product_id,$limit, $offset); 
            if($rows)
                $data["rows"] = $rows;          
            //category
            $category = $this->mod->product_cat_get(0);
            if($category) foreach($category as $r){
                $tam = objectToArray($r);
                $sub = $this->mod->product_cat_get($r->id);
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
                show_404();
            if($this->input->post("ispost")){
                $id = $this->input->post("id");
                $arr["name"] = $this->input->post("name");
                $arr["link"] = $this->input->post("link");
                $arr["product_id"] = $product_id;
                $arr["z_index"] = $this->input->post("z_index");
                /** Thumb **/    
                $path = "uploads/product/sold";
                if(!file_exists($path))
                    mkdir($path);
                if($_FILES["image"]["name"] != null){
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size']	= '10240'; //10M
                    $config['file_name'] = time();
                    $config['width']	 = 150;
                    $config['height']	= 150;
                    $this->load->library('upload', $config);
                    $this->load->library('image_lib');
                    if($this->upload->do_upload('image')){
                        $img = $this->upload->data();
                        $arr["thumb"] = $img['file_name'];
                        #-- Create thumbnail
                        $config['image_library'] = 'gd2';
                        $config['source_image']	= $path."/".$img['file_name'];
                        $this->image_lib->initialize($config);
                        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                    } else {print_r($this->upload->display_errors());}

                    if($id > 0){
                        $old = $this->mod->product_get_by_id($id);
                        if(file_exists("uploads/product/".$old->thumb))
                            unlink("uploads/product/".$old->thumb);
                    }
                }
                $rs = $this->mod->product_sold_update($id, $arr);
                redirect(XADMIN."/product/product_sold/view/".$product_id);
            }
            if($this->uri->segment(6)){
                $id = $this->uri->segment(6);
                $row = $this->mod->product_sold_get_by_id($id);
                if($row)
                    $data["row"] = $row;
            }
            
        break;

        case "delete":
            $id = $this->input->post("id");
            $this->mod->product_sold_delete($id);
            echo "success";
            exit();
        break;
    }
    $data["seo_title"] = "Quản lý khách hàng sử dụng sản phẩm";
    $this->temp->viewa("product_view",$data);
}




}


?>