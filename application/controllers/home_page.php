<?php
$data["module"] = "home";
$about = $this->mod->news_get_by_id(1);
if($about)
    $data["about"] = $about;
    
$hslide = $this->mod->hslide_get();
if($hslide)
$data["hslide"] = $hslide;
$news = $this->mod->news_get(2,1,1,'',8,0);
if($news)
    $data['news'] = $news;
$service = $this->mod->news_cat_get(0,1,1);
foreach($service as &$s){
    $list = $this->mod->news_get_in_tree_cat($s->id,1,20,0);
    $s->list = $list;
}
$data['service'] = $service;

$brands = $this->mod->brands_get(50,0);
if($brands)
    $data['brands'] = $brands;
$feedback = $this->mod->feedback_get(10,0);
if($feedback)
    $data['feedback'] = $feedback;
    
$project = $this->mod->news_get(14,1,1,'',8,0);
if($project)
    $data["project"] = $project;
$videos = $this->mod->video_get(4,0);
if($videos)
    $data["videos"] = $videos;

$caption_video = $this->mod->config_get(array(9));
if($caption_video)
    $data['caption_video'] = $caption_video;

$slogan = $this->mod->config_get(array(11));
if($slogan)
    $data['slogan'] = $slogan;

//SEO
$seo_title = $this->mod->config_get(array(1));
$seo_desc = $this->mod->config_get(array(2));
$seo_key = $this->mod->config_get(array(3));
$data["seo_title"] = $seo_title->content;
$data["seo_desc"] = $seo_desc->content;
$data["seo_key"] = $seo_key->content;
$this->temp->view("home_view",$data);

?>