<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

function __construct(){
    parent::__construct();   
    $this->load->model("user_model","user");            
}
    
function login(){     
    $this->load->view(XADMIN."/users/login_view");
}
   
function do_login(){
    echo $this->user->do_login($_POST["user"], $_POST["pass"]);        
}
        
function captcha(){	   
    $code = md5($_POST["code"]);
    $active_code = $this->session->userdata("activecode");
    if($code == $active_code)
       echo 1;
    else
       echo 0;          
}
         
function logout(){
    $this->session->unset_userdata("admin_id");
    $this->session->sess_destroy();
    redirect(XADMIN);
}   

public function get_capcha(){
    echo generate_capcha();
}



}
