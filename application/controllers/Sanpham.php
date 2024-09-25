<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sanpham extends CI_Controller {

function __construct(){
    parent::__construct();
}

function index($param=null,$offset=0){
    $data = null;
    $data["kind"] = "list_view";
    $data['module'] = 'sanpham';
    $slug = $this->uri->segment(2);
    $order = "id";
    $flag = false;
    switch($slug){
        case 'moi-nhat':
            $order = "id";
            $title = "Sản phẩm mới nhất";
        break;
        case 'danh-gia-cao':
            $order = "star";
            $title = "Sản phẩm được đánh giá nhất";
        break;
        case 'nhieu-nguoi-tai':
            $order = "download";
            $title = "Sản phẩm nhiều người tải nhất";
        break;
        default:
            $flag = true;
        break;
    }
    if($flag)
        show_404();
    $limit = 15;
    $data["cat"] = new stdClass();
        $data["cat"]->name = $title;
    $product = $this->mod->product_get(0,1,-1,null,$limit,$offset,$order);
    if($product)
        $data["rows"] = $product;
    $total = $this->mod->product_get_total(0,1,-1);
    //Get List Product
    
    #------------ PAGINATION -------------
    $config["uri_segment"] = 3;
    $config['base_url'] = PREFIX.'/san-pham/'.$slug.'/';
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
    $data["url"] = "san-pham/index/".$slug;
    //SEO
    $currentPage = floor(($this->uri->segment(4)/$config['per_page']) + 1);
    if($offset == 0)
        $ext_pagi = "";
    elseif($currentPage >= 1 && $total > $limit)
        $ext_pagi = ", trang ".$currentPage;
    else
        $ext_pagi = "";
    $data["seo_title"] = $title.$ext_pagi;
    $data["seo_desc"] = $title.$ext_pagi;
    $this->temp->view("sanpham_view",$data);
}

function category($param=null,$offset=0){
    $data = null;
    $data["kind"] = "list_view";
    $data['module'] = 'sanpham';
    $slug = $this->uri->segment(1);
    $product_cat = $this->mod->product_cat_get_by_slug($slug);
    if(!$product_cat)
        show_404();
    $limit = 15;
    $data["cat"] = $product_cat;
    $product = $this->mod->product_get($product_cat->id,1,-1,null,$limit,$offset);
    if($product)
        $data["rows"] = $product;
    $total = $this->mod->product_get_total($product_cat->id,1,-1);
    //Get List Product
    //active menu
    $data['cat_active'] = $product_cat->id;
    #------------ PAGINATION -------------
    $config["uri_segment"] = 2;
    $config['base_url'] = PREFIX.$slug.'/';
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
    $data["url"] = "san-pham/".$product_cat->slug;
    //SEO
    $currentPage = floor(($this->uri->segment(3)/$config['per_page']) + 1);
    if($offset == 0)
        $ext_pagi = "";
    elseif($currentPage >= 1 && $total > $limit)
        $ext_pagi = ", trang ".$currentPage;
    else
        $ext_pagi = "";
    $data["seo_title"] = $product_cat->seo_title.$ext_pagi;
    $data["seo_desc"] = $product_cat->seo_desc.$ext_pagi;
    $this->temp->view("sanpham_view",$data);
}

function details(){
    $id = 0;
    $data["kind"] = "details";
    $uri = $this->uri->segment(1);
    $slug = explode(".html",$uri);
    //news
    $product = $this->mod->product_get_by_slug($slug[0],1);
    if(!$product)
        show_404();
    if($product){
        $id = $product->id;
        $count = $product->view + 1;
        $arr["view"] = $count;
        $this->mod->product_update($id,$arr);
        $data["row"] = $product;
        $category = $this->mod->product_cat_get_by_id($product->product_cat);
        if($category){
            $data["product_cat"] = $category;
            //active menu
            $data['cat_active'] = $category->id;
        }
        //gallery
        $gallery = $this->mod->product_gallery_get($id);
        if($gallery)
            $data["gallery"] = $gallery;
        $customer = $this->mod->product_sold_get($id);
        if($customer)
            $data["customer"] = $customer;
        //other
        $other = $this->mod->product_get_other($product->product_cat, $id, 6);
        if($other)
            $data["other"] = $other;
        $data["url"] = "san-pham/".$product->slug.".html";
        $data["seo_title"] = $product->seo_title;
        $data["seo_desc"] = $product->seo_desc;
    }else{
        $data["seo_title"] = TITLE;
        $data["seo_desc"] = DESCRIPTION;
    }
    //seo
    $this->temp->view("sanpham_view",$data);
}

function livedemo(){
    $id = 0;
    $data["kind"] = "live";
    $data["module"] = "live";
    $uri = $this->uri->segment(2);
    $slug = explode(".html",$uri);
    //product
    $product = $this->mod->product_get_by_slug($slug[0],1);
    if($product){
        $id = $product->id;
        $menu_live = $this->mod->product_cat_get_menu(0,1);
        foreach($menu_live as &$c){
            $items = $this->mod->product_get_by_cat($c->id);
            $c->items = $items;
        }
        if($menu_live)
            $data["menu_live"] = $menu_live;
        $data["row"] = $product;
        
        $data["seo_title"] = "Live-Demo - ".$product->seo_title;
        $data["seo_desc"] = "Live-Demo - ".$product->seo_desc;
    }else{
        $data["seo_title"] = "Live-Demo - ".TITLE;
        $data["seo_desc"] = "Live-Demo - ".DESCRIPTION;
    }
    $category = $this->mod->product_cat_get();
    if($category)
        $data["category"] = $category;
    

    //seo
    $this->temp->view("sanpham_view",$data);
}

function star(){
    if($this->input->post("p_id")){
        $id = $this->input->post("p_id");
        $rate = $this->input->post("star");
        $row = $this->mod->product_get_by_id($id);
        if($row){
            // Nếu chưa có ai đánh giá thì mặc định là 20 sao
            if($row->star==0)
                $star_p = 20;
            else
                $star_p = $row->star;
            //Tổng số người đã đánh giá sản phẩm
            if($row->count_rate == 0)
                $count_rate_p = 1;
            else
                $count_rate_p = $row->count_rate;
            //Tính trung bình sao do khách hàng đánh giá
            $star = ($star_p*$count_rate_p + $rate) / ($count_rate_p + 1);
            $arr["star"] = $star;
            $arr["count_rate"] = ($count_rate_p + 1);
            $this->mod->product_update($id,$arr);
            echo 'success';              
        }
    }
}

function dat_hang(){
    $id = 0;
    $data["kind"] = "order";
    $data["module"] = "order";
    if($this->uri->segment(2)){
        $uri = $this->uri->segment(2);
        $slug = explode('.html',$uri);
        $row = $this->mod->product_get_by_slug($slug[0],1);
        if(!$row)
            show_404();
        if($this->input->post("is_post")){
            $arr["name"] = $this->input->post("name");
            $arr["phone"] = $this->input->post("phone");
            $arr["email"] = $this->input->post("email");
            $arr["address"] = $this->input->post("address");
            $arr["product_name"] = $row->name;
            $arr["product_id"] = $row->id;
            $arr["time"] = time();
            $arr["state"] = 0;
            $arr["is_read"] = 0;
            $rs = $this->mod->order_update(0, $arr);
            if($rs){
                $body = "";
                $body .= "Người gửi: ".$arr["name"]."<br>";
                $body .= "SĐT: ".$arr["phone"]."<br>";
                $body .= "Địa chỉ: ".$arr["address"]."<br>";
                $body .= "Email: ".$arr["email"]."<br>";
                $body .= "Ngày gửi: ".date('d/m/Y H:i')."<br><hr><br>";
                $body .= "Sản phẩm: ".$row->name."<br><br>";
                $body .= "Giá: ".$row->price."$<br><br>";
                $body .= "Ảnh: <a href='".base_url().$row->slug.".html'><img src='".base_url().'uploads/product/thumb/'.$row->thumb."' width='300px'/></a><br><br>";
                sendMail('son.nguyen@netlink.vn','Đặt hàng mua website tại webdemo',"Textlink - TKweb: Đơn hàng từ ".$arr["name"]." - ".date('d/m/Y'),$body);
            }
            header('Location: '.$_SERVER['HTTP_REFERER'].'?msg=success');
        }
        $data["row"] = $row;
        $data["seo_title"] = "Đặt hàng - ".$row->name;
        $data["seo_desc"] = "Đặt hàng - ".$row->name;
        $this->temp->view("sanpham_view",$data);
    }
    
    
}




}