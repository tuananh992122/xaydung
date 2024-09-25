<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

function __construct(){
    parent::__construct();
    $this->load->model("common_model","mod");
}

function index($offset=0){      
    $data["kind"] = "index";
    $data["module"] = "news";
    $data['cat_name'] = 'Tin tức';
    $limit = 12;
    $news = $this->mod->news_get(2,1,-1,'',$limit, $offset);
    if($news)
        $data["news"] = $news;
    //data sidebar
    $list = $this->mod->news_get(0,1,1,'',10);
    if($list)
        $data['list'] = $list;
    $list_cat = $this->mod->news_cat_get(0,1,1);
    if($list_cat)
        $data['list_cat'] = $list_cat;
    $total = $this->mod->news_get_total(2,1);
    #------------ PAGINATION -------------
    $config["uri_segment"] = 2;
    $config['base_url'] = PREFIX.'tin-tuc/';
    $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
    $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

    $config['cur_tag_open'] = "<li class='active'><a>"; 
    $config['cur_tag_close'] = "</a></li>";
    $config['total_rows'] = $total;
    $config['per_page'] = $limit;
    $this->pagination->initialize($config);
    $data["pagi"] = $this->pagination->create_links();
    $data["offset"] = $offset;
    $data["total"]  = $total;
    //SEO
    $currentPage = floor(($this->uri->segment(2)/$config['per_page']) + 1);
    if($offset == 0)
        $ext_pagi = "";
    elseif($currentPage >= 1 && $total > $limit)
        $ext_pagi = ", trang ".$currentPage;
    else
        $ext_pagi = "";
    $seo_title = $this->mod->config_get(array(4));
    $seo_desc = $this->mod->config_get(array(5));
    $data["seo_title"] = $seo_title->content.$ext_pagi;
    $data["seo_desc"] = $seo_desc->content.$ext_pagi;
    $this->temp->view("news_view",$data);
}

function details(){
    $data = null;
    $data["kind"] = "details";
    $data["module"] = "news";
    $slug = str_replace(".html","",$this->uri->segment(1));  
    //new
    $news = $this->mod->news_get_by_slug($slug);
    if($news){
        $data["row"] = $news;
    }
    else
        show_404();
    $cat = $this->mod->news_cat_get_by_id($news->cat_id);
    if(!$cat)
        show_404();
    $data["parent"] = $cat;  
    $data['pref'] = '';
    if($cat->is_service)
        $data['pref'] = 'dich-vu/';      
    //Update luot xem cho tin tức
    $hits = $news->hits + 1;
    $id = $news->id;
    $this->mod->news_update($id,array("hits"=>$hits));
    //Other
    $other = $this->mod->news_get_other($news->cat_id, $news->id, 10);
    if($other)
        $data["other"] = $other;  
    $list_cat = $this->mod->news_cat_get(0,1,1);
    if($list_cat)
        $data['list_cat'] = $list_cat; 
    $data["seo_title"] = $news->seo_title?$news->seo_title:$news->title;
    $data["seo_desc"] = $news->seo_desc?$news->seo_desc:$news->title;
    
    $this->temp->view("news_view",$data);                   
}

function dichvu($param = null,$offset=0){
    $data["kind"] = "index";
    $data["module"] = "service";
    if($param != null)
    $slug = $param;
    $service_cat = $this->mod->news_cat_get_by_slug($slug);
    if(!$service_cat)
        show_404();
    $data['cat_name'] = $service_cat->name;
    $limit = 12;
    $news = $this->mod->news_get($service_cat->id,1,-1,'',$limit, $offset);
    if($news)
        $data["news"] = $news;
    //data sidebar
    $list = $this->mod->news_get(0,1,1,'',10);
    if($list)
        $data['list'] = $list;
    $list_cat = $this->mod->news_cat_get(0,1,1);
    if($list_cat)
        $data['list_cat'] = $list_cat;
    //data sidebar
    $list = $this->mod->news_get(0,1,1,'',10);
    if($list)
        $data['list'] = $list;
    $list_cat = $this->mod->news_cat_get(0,1,1);
    if($list_cat)
        $data['list_cat'] = $list_cat;
        
    $total = $this->mod->news_get_total(2,1);
    #------------ PAGINATION -------------
    $config["uri_segment"] = 2;
    $config['base_url'] = PREFIX.'tin-tuc/';
    $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
    $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

    $config['cur_tag_open'] = "<li class='active'><a>"; 
    $config['cur_tag_close'] = "</a></li>";
    $config['total_rows'] = $total;
    $config['per_page'] = $limit;
    $this->pagination->initialize($config);
    $data["pagi"] = $this->pagination->create_links();
    $data["offset"] = $offset;
    $data["total"]  = $total;
    //SEO
    $currentPage = floor(($this->uri->segment(2)/$config['per_page']) + 1);
    if($offset == 0)
        $ext_pagi = "";
    elseif($currentPage >= 1 && $total > $limit)
        $ext_pagi = ", trang ".$currentPage;
    else
        $ext_pagi = "";
    $data["seo_title"] = $service_cat->seo_title.$ext_pagi;
    $data["seo_desc"] = $service_cat->seo_desc.$ext_pagi;
    $this->temp->view("news_view",$data);  
}


}