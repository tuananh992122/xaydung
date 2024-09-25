<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class Template {
    
	function template()
	{
		$this->CI =& get_instance();        
	}

    function view($view,$var = NULL){
        $uri = $this->CI->uri->segment_array();
        $var["uri"] = $uri;
        $cat_sv = $this->CI->mod->news_cat_get(0,1,1,1);
        foreach($cat_sv as &$c){
            $child = $this->CI->mod->news_cat_get($c->id,1);
            $c->child = $child;
        }
        $var['cat_sv'] = $cat_sv;
        $cat_sv_other = $this->CI->mod->news_cat_get(0,1,1,0);
        foreach($cat_sv_other as &$co){
            $ochild = $this->CI->mod->news_cat_get($co->id,1);
            $co->child = $ochild;
        }
        $var['cat_sv_o'] = $cat_sv_other;
        $this->CI->load->view("temp/inc_header",$var);        
        $this->CI->load->view($view,$var); 
        $info = $this->CI->mod->config_get(array(12,10,7,8));
        if($info)
            $var['info'] = $info;       
		$this->CI->load->view("temp/inc_footer",$var);
    }
    
    //view new admin
    function viewa($view,$var = NULL)
	{	    	    
		$role = $this->CI->session->userdata("role_admin");
        $var["role"] = $role;
        $uri = $this->CI->uri->segment_array();
        $var["uri"] = $uri;
        $this->CI->load->model("user_model","user");        
		$this->CI->load->view("temp/x_header",$var);
		$this->CI->load->view(XADMIN.'/'.$view,$var);
		$this->CI->load->view("temp/x_footer",$var);
	}
    
    
    
}
?>