<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_FeController extends CI_Controller {	
 	function __construct() {
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->helper('url');
		$this->load->helper('array');
        $this->load->library('authutil');
        $this->load->driver('cache');
        $this->_check_member();
    }
        
    private function _check_member() {
        if (!$this->authutil->is_member_login()) {
            $this->authutil->restrict_frontend();
        }
    }
    
    
}
?>