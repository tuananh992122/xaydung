<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_AdController {

function __construct(){
    parent::__construct();    
    $this->load->model("user_model","user"); 
}    

/*
 * Profile user
 * @param action [optional]
 */
function yourself(){
    $data = null;
    //Update
    if($this->input->post("name")){ 
        $arr["name"] = $this->input->post("name");
        $arr["mobile"] = $this->input->post("mobile");
        $pass = $this->input->post("password");
        $id = $this->input->post("id");
        if($pass != "" || $pass != null)
            $arr["password"] = md5(trim($this->input->post("password")));
        $this->user->users_update($id, $arr);
        $data["thongbao"] = "Cập nhật tài khoản thành công";
    }
    $id = $this->session->userdata("admin_id");
    $row = $this->user->users_get_by_id($id);
    if($row){
        $data["row"] = $row;
        $group = $this->user->group_get_by_id($row->group_id);
        $data["group"] = $group;
    }
    $data["action"] = "yourself";
    $data["seo_title"] = "Tài khoản cá nhân";
    $this->temp->viewa("profile_view",$data);
}

function group($action="view"){        
    $data["action"] = $action;
    $id = $this->session->userdata("admin_id");
    $row = $this->user->users_get_by_id($id);
    $data["user"] = $row;
    switch($action){
        case "view":
            $limit = 20;
            $offset = 0;
            if($this->uri->segment(5))
                $offset = $this->uri->segment(5);                         
            $in = array($row->group_id);
            $g_child = $this->user->group_get($row->group_id);
            if($g_child && $row->group_id != 0) foreach($g_child as $g){
                if(!in_array($g->id, $in))
                    array_push($in, $g->id);
            } 
            $users = $this->user->users_get_in_group($in,$limit,$offset);
            if($users)
                $data["rows"] = $users;
            $users_total = $this->user->users_get_in_group_total($in);
            #------------ PAGINATION -------------
            $config["uri_segment"] = 5;    
            $config['base_url'] = CPANEL.'/profile/group/view/';
            $config['total_rows'] = $users_total;
            $config['per_page'] = $limit; 
            $this->pagination->initialize($config);
            $data["pagi"] = $this->pagination->create_links();   
            $data["offset"] = $offset; 
            $data["total"]  = $users_total;
        break;
    }
    $data["seo_title"] = "Thành viên trong nhóm";
    $this->temp->viewa("profile_view",$data);
}


}