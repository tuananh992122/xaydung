<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{

function __construct(){
    parent::__construct();        
}    

public function index(){     
    if(!$this->session->userdata("admin_id"))
        redirect(XADMIN."/user/login");
    $data = null; 
    $ad_id = $this->session->userdata("admin_id");
    $user = $this->user->users_get_by_id($ad_id);
    $data["user"] = $user;
    //SEO
    $seo_title = $this->mod->config_get(array(1));
    $seo_desc = $this->mod->config_get(array(2));
    $seo_key = $this->mod->config_get(array(3));
    $data["seo_title"] = $seo_title->content;
    $data["seo_desc"] = $seo_desc->content;
    $data["seo_key"] = $seo_key->content;
	$this->temp->viewa('home_view',$data);    
}

function permission(){ 
    $this->load->view(XADMIN."/users/permission_view");
}

}
