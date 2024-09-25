<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ad_user extends MY_AdController {

function __construct(){
    parent::__construct();    
    $this->load->model("user_model","user"); 
}    

/********* GROUP **************/

function group($action=null){
    $data = null;
    //$chmod = $this->return_chmod();
    switch($action){
        case "addedit":
            if($this->input->post("name")){
                $r["name"] = $this->input->post("name");
                $r["parent"] = $this->input->post("parent");
                $id = $this->input->post("id");
                $group_id = $this->user->group_update($id, $r);
                //permission
                $role_ids = $this->input->post("role_ids");
                $this->user->group_permission($group_id, $role_ids);
                #----- Insert Log
                if($id == 0)
                    $log["content"] = "<span class='dong'>Tạo mới:</span> nhóm thành viên #".$group_id."<br/> Tên nhóm: ".$r["name"];
                else     
                    $log["content"] = "<span class='dong'>Cập nhật</span> nhóm thành viên: #".$group_id."<br/> Tên nhóm: ".$r["name"];
                $this->user->log_insert($log); 
                redirect(XADMIN."/ad_user/group");
            }
            //map menu - group
            $arr_map = array(); 
            if($this->uri->segment(5, -1) >= 0){
                $id = $this->uri->segment(5);
                $group = $this->user->group_get_by_id($id);
                if($group)
                    $data["row"] = $group;                
                $map = $this->user->group_get_map_menu($id);
                if($map) foreach($map as $m){
                    array_push($arr_map, $m->menu_id);
                }                         
            }
            $data["map"] = $arr_map;
            //list menu
            $menu = $this->user->menu_get_list();
            if($menu)
                $data["menu"] = $menu;
            //All group
            $group_all = $this->user->group_get(0);
            if($group_all)
                $data["group_all"] = $group_all;                               
        break;
        case "delete":
            $id = $this->input->post("id");
            $group = $this->user->group_get_by_id($id);
            echo $this->user->group_delete_by_id($id);
            #----- Insert Log            
            $log["content"] = "<span class='money'>Xóa:</span> nhóm thành viên #{$id}<br/> Tên nhóm: ".$group->name;                    
            $this->user->log_insert($log);
            exit();
        default:
            $rows = $this->user->group_get(0);
            if($rows)
                $data["rows"] = $rows;
            $action = "list";
    }
    $data["action"] = $action;
    $this->temp->viewa("users/group_view",$data);    
}

/*********** USERS *************/

function users($action=null){
    $data = null;
    switch($action){
        case "addedit": 
            if($this->input->post("username")){     
                //validate
                $id = $this->input->post("id");
                $rs = "success";
                if($id == 0){
                    $user = $this->input->post("username");
                    $email = $this->input->post("email");
                    $ckemail = $this->user->email_exist($email);
                    if($ckemail == "exist")
                        $rs = "email";
                    $ckuser = $this->user->username_exist($user);
                    if($ckuser == "exist")
                        $rs = "username"; 
                }    
                //Update
                if($rs == "success"){                                        
                    $r["name"] = $this->input->post("name");
                    $r["mobile"] = $this->input->post("mobile");
                    $group_ids = $this->input->post("group_ids");
                    if($id == 0){
                        $r["username"] = $this->input->post("username");
                        $r["email"] = $this->input->post("email");
                        $r["date"] = date("Y-m-d");
                        $r["password"] = md5($this->input->post("password"));    
                    }else{
                        $pass = $this->input->post("password");
                        if($pass != "" || $pass != null)
                            $r["password"] = md5($this->input->post("password"));    
                    }
                    $user_id = $this->user->users_update($id, $r);
                    if($id == 0)
                        $data["success"] = "Tài khoản được tạo thành công.";
                    else
                        $data["success"] = "Cập nhật thành công.";
                    $this->user->users_group_mix($user_id, $group_ids);
                    #----- Insert Log
                    if($id == 0)
                        $log["content"] = "<span class='dong'>Tạo mới:</span> thành viên #".$user_id."<br/> Họ tên: ".$r["name"];
                    else     
                        $log["content"] = "<span class='dong'>Cập nhật</span> thành viên: #".$user_id."<br/> Họ tên: ".$r["name"];                    
                    $this->user->log_insert($log);
                    redirect(XADMIN."/ad_user/users");     
                }elseif($rs == "email"){
                    $data["send"] = $_POST;
                    $data["error"] = "Email đăng ký đã tồn tại.";
                }elseif($rs == "username"){
                    $data["send"] = $_POST;
                    $data["error"] = "Username đăng ký đã tồn tại.";
                }                          
            }
            //Load view
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $user = $this->user->users_get_by_id($id);
                if($user)
                    $data["row"] = $user;
                //group_ids
                $group_ids = $this->user->users_group_mix_get($id);    
                if($group_ids) foreach($group_ids as $gid){
                    $data["group_ids"][] = $gid->group_id;
                }
            }
            $group = $this->user->group_get(0);
            if($group)
                $data["group"] = $group;
                
        break;
        case "delete":
            $id = $this->input->post("id");
            $user = $this->user->users_get_by_id($id);
            echo $rs = $this->user->users_delete($id);
            #----- Insert Log            
            $log["content"] = "<span class='money'>Xóa:</span> thành viên #{$id}<br/> Tên đăng nhập: ".$user->username."<br/> Họ tên: ".$user->name;                    
            $this->user->log_insert($log);
            exit();
        break;
        case "lock":
            $id = $this->input->post("id");
            $this->user->users_lock($id);
            echo "success";
            exit();
        break;
        default:
            $limit = 30;
            //Lock
            $lock = -1;
            if($this->uri->segment(4))
                $lock = $this->uri->segment(4);
            //Offset    
            $offset = 0;
            if($this->uri->segment(6))
                $offset = $this->uri->segment(6);                                
            $rows = $this->user->users_get($lock, $limit, $offset);
            if($rows){
                $arr = array();
                foreach($rows as $r){
                    $tam = objectToArray($r);
                    $tam_group = array();
                    $group = $this->user->users_get_group($r->id);
                    if($group) foreach($group as $g){
                        array_push($tam_group, $g->gname);
                    }
                    $tam["group"] = implode(", ",$tam_group);
                    $data["rows"][] = $tam;    
                }                
            } 
                                            
            $total = $this->user->users_get_total($lock);
            #------------ PAGINATION -------------
            $config["uri_segment"] = 6;    
            $config['base_url'] = CPANEL.'/ad_user/users/'.$lock;
            $config['total_rows'] = $total;
            $config['per_page'] = $limit; 
            $this->pagination->initialize($config);
            $data["pagi"] = $this->pagination->create_links();   
            $data["offset"] = $offset;                     
            $action = "list";            
    }
    $data["action"] = $action;
    $this->temp->viewa("users/user_view",$data);
}


/****************** MENU ***************/
function menu($action=null){
    switch($action){
        case "addedit": 
            if($this->input->post("name")){
                $r["name"] = $this->input->post("name");
                $r["location"] = trim($this->input->post("location"));
                $r["order"] = $this->input->post("order");            
                $r["parent"] = $this->input->post("parent");
                $r["status"] = $this->input->post("status");
                $id = $this->input->post("id");
                $this->user->menu_update($id, $r);
                redirect(XADMIN."/ad_user/menu");  
            }   
            if($this->uri->segment(5)){
                $id = $this->uri->segment(5);
                $menu = $this->user->menu_get_by_id($id);
                if($menu)
                    $data["row"] = $menu;
            }
            //Danh sach menu            
            $menu_list = $this->user->menu_get_list();
            if($menu_list)
                $data["menu_list"] = $menu_list;
        break;
        case "delete":
            $id = $this->input->post("id");
            $menu = $this->user->menu_get_by_level($id);
            if($menu)
                echo "has_sub";                
            else
                echo $rs = $this->user->menu_delete($id);                                            
            exit();
        break;
        case "status":
            $id = $this->input->post("id");
            $menu = $this->user->menu_get_by_id($id);
            if($menu->status == 0)  
                $status = 1;
            else
                $status = 0;
            $rs = $this->user->menu_update($id, array("status"=>$status));            
            echo "success";
            exit();        
        break;
        case "menu_get_parent":
            $id = $this->uri->segment(5);
            $menu = $this->user->menu_get_by_id($id);
            echo $menu->parent; 
            exit();
        break;
        default:
            //Danh sach menu            
            $menu_list = $this->user->menu_get_list();
            if($menu_list)
                $data["rows"] = $menu_list;                    
            $action = "list";                
    }
    $data["action"] = $action;
    $this->temp->viewa("users/menu_view",$data);    
}




}
