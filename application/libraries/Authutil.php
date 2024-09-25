<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Authutil{
    
#------ Check BackEnd Login ------
public function restrict_backend(){
    redirect(XADMIN.'/user/login');
}

function is_login(){
	$this->CI = &get_instance();
	if($this->CI->session->userdata('admin_id')){
        return TRUE;
	}
	return FALSE;
}

#------ Check FrontEnd Login ------
public function restrict_frontend(){
    redirect('');
}

function is_member_login(){
    $this->CI = &get_instance();
	if($this->CI->session->userdata('ad_member')){
        return TRUE;
	}
	return FALSE;        
}

function check_permission($url=null){ 
    $this->CI = &get_instance();
    $this->CI->load->model("user_model","user");
    //permission  
    $group_id = $this->CI->session->userdata("group_id");
    //Menu 
    $menu = $this->CI->user->menu_get_map_by_group($group_id);
    //URL
    $ck = false;
    if($url == null){        
        $temp = explode(CPANEL."/",$_SERVER["REQUEST_URI"]);
        if(isset($temp[1])){ 
            $url = $temp[1];                              
        }else    
            return $ck;
    }
    //detect permission
    if($menu) foreach($menu as $m){             
        if(strpos($url, $m->location) !== false){            
            $ck = $m->chmod;                      
        }              
    }    
    if($group_id == 0)
        $ck = 777;
    return $ck;     
}
        
        
}