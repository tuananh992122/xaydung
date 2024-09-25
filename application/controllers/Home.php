<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

function __construct(){
    parent::__construct();
}


function index($uri=null){
    $data = null;
    if($uri == null)
        include_once CONTROLLERS."home_page.php";
    else{
        $uri = str_replace(".html","",$uri);
        $slug = $this->mod->slug_get_by_slug($uri);
        if($slug):
            $controller = $slug->controller;
            $function = $slug->function;
            $param = $slug->param;
            //Load file
            include_once CONTROLLERS.$controller.".php";
            $oController =  new $controller();
            $oController->$function($param);
        else:
            $seg = $this->uri->segment_array();
            $controller = str_replace("-","_",$seg[1]);
            $controller = str_replace(".html","",$controller);
            if(isset($seg[2]))
                $function = str_replace("-","_",$seg[2]);
            else
                $function = "index";
            $param = null;
            if(isset($seg[3]))
                $param = $seg[3];
            //Check Exist
            if(file_exists(CONTROLLERS.$controller.".php"))
                include_once CONTROLLERS.$controller.".php";
            else
                show_404();
            $oController =  new $controller();
            if(method_exists($oController, $function))
                $oController->$function($param);
            else
                show_404();
        endif;
    }
}

function search(){
    if($this->uri->segment(2)){
        $uri = $this->uri->segment(2);
        $uri_exp = explode("k=",$uri);
        $dkey = urldecode($uri_exp[1]);
        $key = $dkey;
        $limit = 15;
        $offset = 0;
        if($this->uri->segment(3))
            $offset = $this->uri->segment(3);
        $data["cat_name"] = "Search: ".$key;
        $data["kind"] = "index";
        //Product
        $news = $this->mod->news_get(0,1,-1,$key,$limit,$offset);
        if($news)
            $data["news"] = $news;
        
        $total = $this->mod->news_get_total(0,1,-1,$key);
        #------------ PAGINATION -------------
        $uri = 'k='.$key;
        $data["keyword"] = $key;
        $config["uri_segment"] = 3;
        $config['base_url'] = PREFIX.'tim-kiem/'.$uri."/";
        //$config['base_url'] = PREFIX.'tim-kiem?k='.$key.'&per_page='.$offset;
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
         
        $config['cur_tag_open'] = "<li class='active'><span>";
        $config['cur_tag_close'] = "</span></li>";
        $this->pagination->initialize($config);
        $data["pagi"] = $this->pagination->create_links();
        $data["offset"] = $offset;
        $data["total"]  = $total;
        //SEO
        $currentPage = floor(($offset/$config['per_page']) + 1);
        if($offset == 0)
            $ext_pagi = "";
        elseif($currentPage >= 1 && $total > $limit)
            $ext_pagi = ", trang ".$currentPage;
        else
            $ext_pagi = "";           
        $data["seo_title"] = "Search: ".$key.$ext_pagi;
        $data["seo_desc"] = "Search: ".$key.$ext_pagi;
        $this->temp->view("news_view",$data);
    }
}

function gioi_thieu(){
    $data = null;
    $data["module"] = "about";
    $data["row"] = $this->mod->news_get_by_id(1);
    $data["seo_title"] = "Giới thiệu";
    $this->temp->view("gioithieu_view",$data);
}

function lienhe(){
    $data = null;
    $data["module"] = "contact";
    if($this->input->post("name")){
        $arr["name"] = $this->input->post("name");
        $arr["email"] = $this->input->post("email");
        $arr["content"] = $this->input->post("content");
        $arr["phone"] = $this->input->post("mobile");
        $arr["address"] = $this->input->post("address");
        $arr["time"] = time();
        $this->mod->contact_update(0, $arr);
        header('Location: '.$_SERVER['HTTP_REFERER']."?msg=success");
    }
    if(isset($_GET["msg"]))
        $data["thongbao"] = "Cảm ơn bạn, thông tin đã được gửi thành công.";
    
    $data["seo_title"] = "Liên hệ";
    $data["seo_desc"] = "Liên hệ";
    $this->temp->view("lienhe_view",$data);
}
/** Common Function **/
function get_captcha(){
    echo generate_capcha();
}

function check_captcha(){
    $code = md5($this->input->post("code"));
    $active_code = $this->session->userdata("activecode");
    if($code == $active_code)
        echo "true";
    else
        echo "false";
}



}