<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MY_AdController {

function __construct(){
    parent::__construct();
    $this->load->model("common_model","mod");
}


function config($action="view"){
    $data["action"] = $action;
    switch($action){
        case "view":
            //Trang chu
            $ids = array(7,8,9,10,11,12,13);
            $rows = $this->mod->config_get($ids);
            if($rows)
                $data["rows"] = $rows;
        break;
        case "addedit":
            if($this->input->post("content")){
                $id = $this->input->post("id");
                $arr["content"] = $this->input->post("content");
                if($id > 0){
                    $this->mod->config_update($id, $arr);
                    redirect(XADMIN."/setting/config");
                }
            }
            $id = $this->uri->segment(5);
            $row = $this->mod->config_get(array($id));
            if($row)
                $data["row"] = $row;
        break;
    }
    $this->temp->viewa("config_view",$data);
}

function onpage($action="view"){
    $data["action"] = $action;
    switch($action){
        case "view":
            //Trang chu
            $ids = array(1,2,3);
            $rows = $this->mod->config_get($ids);
            if($rows)
                $data["rows"] = $rows;
            //Trang tin tuc
            $ids = array(4,5);
            $rows = $this->mod->config_get($ids);
            if($rows)
                $data["news"] = $rows;
        break;
        case "addedit":
            if($this->input->post("content")){
                $id = $this->input->post("id");
                $arr["content"] = $this->input->post("content");
                if($id > 0){
                    $this->mod->config_update($id, $arr);
                    redirect(XADMIN."/setting/onpage");
                }
            }
            $id = $this->uri->segment(5);
            $row = $this->mod->config_get(array($id));
            if($row)
                $data["row"] = $row; 
        break;
    }
    $data["seo_title"] = "Onpage";
    $this->temp->viewa("onpage_view",$data);
}

function contact($action="view"){
    $data["action"] = $action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":
            $limit = 30;
            $offset = 0;
            if($this->uri->segment(6))
                $offset = $this->uri->segment(6);
            /** Filter **/
            $f_read = -1;
            if($this->uri->segment(5)){
                //read='+read
                $uri = $this->uri->segment(5);
                $uri_exp = explode("&ad&",$uri);
                $f_read = urldecode(substr($uri_exp[0],5));
            }
            /** Get data **/
            $rows = $this->mod->contact_get($limit, $offset, $f_read);
            if($rows)
                $data["rows"] = $rows;
            $total = $this->mod->contact_get_total($f_read);
            //Filter
            $data["f_read"] = $f_read;
            #------------ PAGINATION -------------
            $uri = 'read='.$f_read;
            $config["uri_segment"] = 6;
            $config['base_url'] = CPANEL.'/setting/contact/view/'.$uri.'/';
            $config['total_rows'] = $total;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);
            $data["pagi"] = $this->pagination->create_links();
            $data["offset"] = $offset;
            $data["total"]  = $total;
        break;

        case "details":
            if($chmod < 444)
                show_404_ad();
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $row = $this->mod->contact_get_by_id($id);
                if($row)
                    $data["row"] = $row;
                $this->mod->contact_update($id, array("is_read"=>1));
            }

        break;

        case "delete":
            $id = $this->input->post("id");
            $this->mod->contact_delete($id);
            echo "success";
            exit();
        break;
    }
    $data["seo_title"] = "Thông tin liên hệ";
    $this->temp->viewa("contact_view",$data);
}

function brand($action="view"){
    $data["action"] = $action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":            
            $brand = $this->mod->brand_get();
            if($brand)
                $data["rows"] = $brand;             
        break;
        case "addedit";
            if($this->input->post("ispost")){
                $id = $this->input->post("id");
                $arr["name"] = $this->input->post("name");
                $arr["address"] = $this->input->post("address");
                $arr["hotline"] = $this->input->post("hotline");
                $arr["phone"] = $this->input->post("phone");
                $arr["time_active"] = $this->input->post("time_active");
                $arr["map"] = $this->input->post("map");
                $arr["z_index"] = $this->input->post("z_index");
                $arr["content"] = $this->input->post("content");
                $slug = string_2_slug($this->input->post("slug"));
                if($slug == "")
                    $slug = string_2_slug($this->input->post("name"));
                $arr["slug"] = $slug;
                $arr["seo_title"] = $this->input->post("seo_title");
                $arr["seo_desc"] = $this->input->post("seo_desc");                
                if(isset($_POST["state"]))
                    $arr["state"] = 1;
                else
                    $arr["state"] = 0;
                $path = "uploads/brand";
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
                        $config['width']	 = 150;
                        $config['height']	= 150;
                        $config['new_image'] = $path."/thumb/".$img['file_name'];
                        $this->image_lib->initialize($config);
                        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                    } else {print_r($this->upload->display_errors());}

                    if($id > 0){
                        $old = $this->mod->brand_get_by_id($id);
                        if(file_exists($path."/".$old->image))
                            unlink($path."/".$old->image);
                        if(file_exists($path."/thumb/".$old->image))
                            unlink($path."/thumb/".$old->image);
                    }
                }    
                $rs = $this->mod->brand_update($id, $arr);
                redirect(XADMIN."/setting/brand");
            }
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $brand = $this->mod->brand_get_by_id($id);
                if($brand)
                    $data["row"] = $brand;
            }
            $max = $this->mod->brand_get_max();
            $data["max"] = $max;   
        break;
        case "delete":
            $id = $this->input->post("id");
            $this->mod->brand_delete($id);
            exit("success");
        break;
        case "switch_state":
            $id = $this->input->post("id");
            $state = 0;
            $brand = $this->mod->brand_get_by_id($id);
            if($brand->state == 0)
                $state = 1;
            $this->mod->brand_update($id, array("state"=>$state));
            echo "success";
            exit();
        break;
    }
    $data["seo_title"] = "Cơ sở, Chi nhánh";
    $this->temp->viewa("brand_view",$data);
}

function province($action="view"){
    $data["action"] = $action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":                        
            $limit = 30;
            $offset = 0;
            if($this->uri->segment(5))
                $offset = $this->uri->segment(5);    
            $rows = $this->mod->province_get($limit, $offset);
            if($rows)
                $data["rows"] = $rows;
            $total = $this->mod->province_get_total();    
            #------------ PAGINATION -------------
            $config["uri_segment"] = 5;
            $config['base_url'] = CPANEL.'/setting/province/view/';
            $config['total_rows'] = $total;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);
            $data["pagi"] = $this->pagination->create_links();
            $data["offset"] = $offset;
            $data["total"]  = $total;    
        break;

        case "addedit":
            if($chmod < 777)
                show_404_ad();
            if($this->input->post("name")){
                $id = $this->input->post("id");
                $arr["name"] = $this->input->post("name");
                if(isset($_POST["state"]))
                    $arr["state"] = 1;
                else
                    $arr["state"] = 0;
                $slug = string_2_slug($this->input->post("name"));
                $arr["slug"] = $slug;
                $rs = $this->mod->province_update($id, $arr);
                redirect(XADMIN."/setting/province");
            }
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $cat = $this->mod->province_get_by_id($id);
                if($cat)
                    $data["row"] = $cat;
            }
        break;

        case "delete":
            $id = $this->input->post("id");
            $this->mod->province_delete($id);
            echo "success";
            exit();
        break;

        case "switch_state":
            $id = $this->input->post("id");
            $state = 0;
            $province = $this->mod->province_get_by_id($id);
            if($province->state == 0)
                $state = 1;
            $this->mod->province_update($id, array("state"=>$state));
            echo "success";
            exit();
        break;
    }
    $data["seo_title"] = "Địa chỉ";
    $this->temp->viewa("province_view",$data);
}


function district($province_id, $action="view"){
    $data["action"] = $action;
    $chmod = $this->return_chmod();
    $data["chmod"] = $chmod;
    switch($action){
        case "view":      
            $province = $this->mod->province_get_by_id($province_id);
            if($province)
                $data["province"] = $province;                  
            $limit = 30;
            $offset = 0;
            if($this->uri->segment(6))
                $offset = $this->uri->segment(6);    
            $rows = $this->mod->district_get($province_id,  $limit, $offset);
            if($rows)
                $data["rows"] = $rows;
            $total = $this->mod->district_get_total($province_id);    
            #------------ PAGINATION -------------
            $config["uri_segment"] = 6;
            $config['base_url'] = CPANEL.'/setting/district/'.$province_id.'/view/';
            $config['total_rows'] = $total;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);
            $data["pagi"] = $this->pagination->create_links();
            $data["offset"] = $offset;
            $data["total"]  = $total;    
        break;

        case "addedit":
            if($chmod < 777)
                show_404_ad();
            if($this->input->post("name")){
                $id = $this->input->post("id");
                $arr["name"] = $this->input->post("name");
                $arr["province_id"] = $this->input->post("province_id");
                if(isset($_POST["state"]))
                    $arr["state"] = 1;
                else
                    $arr["state"] = 0;
                $slug = string_2_slug($this->input->post("name"));
                $arr["slug"] = $slug;
                $rs = $this->mod->district_update($id, $arr);
                $data["thongbao"] = "Cập nhật thành công!";
                //redirect(XADMIN."/setting/district/".$arr["province_id"]);
            }
            $province_id = $this->uri->segment(4);
            $province = $this->mod->province_get_by_id($province_id);
            if($province)
                $data["province"] = $province;
            if($this->uri->segment(6)){
                $id = $this->uri->segment(6);
                $cat = $this->mod->district_get_by_id($id);
                if($cat)
                    $data["row"] = $cat;
            }
        break;

        case "delete":
            $id = $this->input->post("id");
            $this->mod->district_delete($id);
            echo "success";
            exit();
        break;

        case "switch_state":
            $id = $this->input->post("id");
            $state = 0;
            $district = $this->mod->district_get_by_id($id);
            if($district->state == 0)
                $state = 1;
            $this->mod->district_update($id, array("state"=>$state));
            echo "success";
            exit();
        break;
    }
    $data["seo_title"] = "Địa chỉ";
    $this->temp->viewa("district_view",$data);
}

function hslide($action = null){
    $path = "uploads/hslide/";
    switch($action){
        case 'addedit':
            if($this->input->post("title")){

                $id = $this->input->post("id");
                $r["title"] = $this->input->post("title");
                $r["link"] = $this->input->post("link");
                $r["link_demo"] = $this->input->post("link_demo");
                $r["caption"] = $this->input->post("caption");
                $r["z_index"] = $this->input->post("z_index");
                $r["is_active"] = $this->input->post("is_active");
                //Image Upload
                $path = "uploads/hslide";
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
                        $r["image"] = $img['file_name'];
                        #-- Create thumbnail
                        $config['image_library'] = 'gd2';
                        $config['source_image']	= $path."/".$img['file_name'];
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['thumb_marker'] = "";
                        $config['width']	 = 200;
                        $config['height']	= 200;
                        $config['new_image'] = $path."/thumb/".$img['file_name'];
                        $this->image_lib->initialize($config);
                        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                    } else {print_r($this->upload->display_errors());}

                    if($id > 0){
                        $old = $this->mod->hslide_get_by_id($id);
                        if(file_exists("uploads/hslide/".$old->image))
                            unlink("uploads/hslide/".$old->image);
                        if(file_exists("uploads/hslide/thumb/".$old->image))
                            unlink("uploads/hslide/thumb/".$old->image);
                    }
                }
                //End Upload
                
                $this->mod->hslide_update($id, $r);
                $data["thongbao"] = "Cập nhật thành công!";
            }

            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $hslide = $this->mod->hslide_get_by_id($id);
                if($hslide)
                    $data["row"] = $hslide;
            }
            break;
        case "delete":
            $id = $this->input->post("id");
            $this->mod->hslide_delete($id);
            exit("success");
        break;
        case "is_active":
            $id = $this->input->post("id");
                $menu = $this->mod->hslide_get_by_id($id);
                if($menu->is_active == 0)
                    $is_active = 1;
                else
                    $is_active = 0;
                $rs = $this->mod->hslide_update($id, array("is_active"=>$is_active));
                echo "success";
                exit();
        break;
        default:
            $total = $this->mod->hslide_get_total();
            $limit = 8;
            $offset = 0;
            if($this->uri->segment(4))
                $offset = $this->uri->segment(4);

            $rows = $this->mod->hslide_get($limit, $offset);
            if($rows)
                $data['rows'] = $rows;

            #------------ PAGINATION -------------
            $config["uri_segment"] = 4;
            $config['base_url'] = CPANEL.'/setting/hslide/';
            $config['total_rows'] = $total;
            $config['per_page'] = $limit;
            $config['full_tag_open'] = '<div class="pagination pagination-right">';
            $config['full_tag_close'] = '</div><!--pagination-->';
            $this->pagination->initialize($config);
            $data["pagi"] = $this->pagination->create_links();
            $data["offset"] = $offset;
            $action = "list";
    }
    $data["action"] = $action;
    $data["seo_title"] = "Quản lý hslide";
    $this->temp->viewa("hslide_view",$data);
}

function feedback($action = null){
        $path = "uploads/feedback/";
        switch($action){
            case 'addedit':
                if($this->input->post("name")){
                    $id = $this->input->post("id");
                    $r["name"] = $this->input->post("name");
                    $r["company"] = $this->input->post("company");
                    $r["feedback"] = $this->input->post("feedback");
                    $r["z_index"] = $this->input->post("z_index");
                    
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
                            $r["image"] = $img['file_name'];
                            #-- Create thumbnail
                            $config['image_library'] = 'gd2';
                            $config['source_image']	= $path."/".$img['file_name'];
                            $config['create_thumb'] = TRUE;
                            $config['maintain_ratio'] = TRUE;
                            $config['thumb_marker'] = "";
                            $config['width']	 = 200;
                            $config['height']	= 200;
                            $config['new_image'] = $path."/thumb/".$img['file_name'];
                            $this->image_lib->initialize($config);
                            if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                        } else {print_r($this->upload->display_errors());}
                        if($id > 0){
                            $old = $this->mod->feedback_get_by_id($id);
                            if(file_exists($path.$old->image))
                                unlink($path.$old->image);
                            if(file_exists($path."thumb/".$old->image))
                                unlink($path."thumb/".$old->image);
                        }
                    }
                    $this->mod->feedback_update($id, $r);
                    $data["thongbao"] = "Cập nhật thành công!";
                }

                if($this->uri->segment(5)){
                    $id = $this->uri->segment(5);
                    $feedback = $this->mod->feedback_get_by_id($id);
                    if($feedback)
                        $data["row"] = $feedback;
                }
                break;
            case "delete":
                $id = $this->input->post("id");
                $this->mod->feedback_delete($id);
                exit("success");
            break;
            default:
                $total = $this->mod->feedback_get_total();
                $limit = 8;
                $offset = 0;
                if($this->uri->segment(4))
                    $offset = $this->uri->segment(4);

                $rows = $this->mod->feedback_get($limit, $offset);
                if($rows)
                    $data['rows'] = $rows;

                #------------ PAGINATION -------------
                $config["uri_segment"] = 4;
                $config['base_url'] = CPANEL.'/setting/feedback/';
                $config['total_rows'] = $total;
                $config['per_page'] = $limit;
                $config['full_tag_open'] = '<div class="pagination pagination-right">';
                $config['full_tag_close'] = '</div><!--pagination-->';
                $this->pagination->initialize($config);
                $data["pagi"] = $this->pagination->create_links();
                $data["offset"] = $offset;
                $action = "list";
        }
        $data["action"] = $action;
        $data["seo_title"] = "Quản lý feedback";
        $this->temp->viewa("feedback_view",$data);
    }
    
    function brands($action = null){
        $path = "uploads/brands/";
        switch($action){
            case 'addedit':
                if($this->input->post("name")){
                    $id = $this->input->post("id");
                    $r["name"] = $this->input->post("name");
                    $r["link"] = $this->input->post("link");
                    $r["z_index"] = $this->input->post("z_index");
                    
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
                            $r["thumb"] = $img['file_name'];
                            #-- Create thumbnail
                            $config['image_library'] = 'gd2';
                            $config['source_image']	= $path."/".$img['file_name'];
                            $config['create_thumb'] = TRUE;
                            $config['maintain_ratio'] = TRUE;
                            $config['thumb_marker'] = "";
                            $config['width']	 = 200;
                            $config['height']	= 200;
                            $config['new_image'] = $path."/thumb/".$img['file_name'];
                            $this->image_lib->initialize($config);
                            if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
                        } else {print_r($this->upload->display_errors());}
                        if($id > 0){
                            $old = $this->mod->brands_get_by_id($id);
                            if(file_exists($path.$old->image))
                                unlink($path.$old->image);
                            if(file_exists($path."thumb/".$old->image))
                                unlink($path."thumb/".$old->image);
                        }
                    }
                    $this->mod->brands_update($id, $r);
                    $data["thongbao"] = "Cập nhật thành công!";
                }

                if($this->uri->segment(5)){
                    $id = $this->uri->segment(5);
                    $brands = $this->mod->brands_get_by_id($id);
                    if($brands)
                        $data["row"] = $brands;
                }
                break;
            case "delete":
                $id = $this->input->post("id");
                $this->mod->brands_delete($id);
                exit("success");
            break;
            default:
                $total = $this->mod->brands_get_total();
                $limit = 8;
                $offset = 0;
                if($this->uri->segment(4))
                    $offset = $this->uri->segment(4);

                $rows = $this->mod->brands_get($limit, $offset);
                if($rows)
                    $data['rows'] = $rows;

                #------------ PAGINATION -------------
                $config["uri_segment"] = 4;
                $config['base_url'] = CPANEL.'/setting/brands/';
                $config['total_rows'] = $total;
                $config['per_page'] = $limit;
                $config['full_tag_open'] = '<div class="pagination pagination-right">';
                $config['full_tag_close'] = '</div><!--pagination-->';
                $this->pagination->initialize($config);
                $data["pagi"] = $this->pagination->create_links();
                $data["offset"] = $offset;
                $action = "list";
        }
        $data["action"] = $action;
        $data["seo_title"] = "Quản lý đối tác";
        $this->temp->viewa("brands_view",$data);
    }
    
    function video($action=null){
        switch($action){
            case 'addedit':
                if($this->input->post("title")){
                    $id = $this->input->post("id");
                    $title = $this->input->post("title");
                    $r["title"] = $title; 
                    $r["url"] = $this->input->post("url");
                    $r["time_created"] = time();
                    $r["is_active"] = $this->input->post("is_active");
                    $this->mod->video_update($id, $r);
                    $data["thongbao"] = "Cập nhật thành công!";
                }
                
                if($this->uri->segment(5)){
                    $id = $this->uri->segment(5);
                    $video = $this->mod->video_get_by_id($id);
                    if($video)
                        $data["row"] = $video;
                }
                break;
            case 'delete':
                $id = $this->input->post("id");
                echo $this->mod->video_delete($id);
                exit();
                break;
            case "is_active":
                $id = $this->input->post("id");
                    $menu = $this->mod->video_get_by_id($id);
                    if($menu->is_active == 0)  
                        $is_active = 1;
                    else
                        $is_active = 0;
                    $rs = $this->mod->video_update($id, array("is_active"=>$is_active));            
                    echo "success";
                    exit();     
            break;
            default:
                $total = $this->mod->video_get_total();
                $limit = 8;
                $offset = 0;
                if($this->uri->segment(4))
                    $offset = $this->uri->segment(4);
                    
                $rows = $this->mod->video_get($limit, $offset);
                if($rows)
                    $data['rows'] = $rows;
                    
                #------------ PAGINATION -------------
                $config["uri_segment"] = 4;    
                $config['base_url'] = CPANEL.'/lib/manage_video/';
                $config['total_rows'] = $total;
                $config['per_page'] = $limit; 
                $config['full_tag_open'] = '<div class="pagination pagination-right">';
                $config['full_tag_close'] = '</div><!--pagination-->';
                $this->pagination->initialize($config);
                $data["pagi"] = $this->pagination->create_links();   
                $data["offset"] = $offset;                     
                $action = "list";
        }
        $data["action"] = $action;
        $data["seo_title"] = "Quản lý Video";
        $this->temp->viewa("video_view",$data);
    }







}