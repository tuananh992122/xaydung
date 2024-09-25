<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_AdController extends CI_Controller {
    
    private $chmod;
    
 	function __construct() {
		parent::__construct();
        $this->load->model("user_model","user");        
        $this->_check_auth();
    }
        
    private function _check_auth(){
        if (!$this->authutil->is_login()) {
            $this->authutil->restrict_backend();
        }        
        $ck = $this->authutil->check_permission();
        //die;
        if($ck == false)
            redirect(XADMIN."/home/permission");
        $this->chmod = $ck;                  
    }
    
    function return_chmod(){
        return $this->chmod;
    }
}
?>