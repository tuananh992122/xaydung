<?if(isset($hslide)):?>
<!-- Slider area start here  --> 
<div class="slider-area-home">
	<div class="bend niceties preview-2">
		<div id="ensign-nivoslider" class="slides">	
            <?$i=0;foreach($hslide as $slide):$i++;?>
			<img src="<?=PREFIX.'uploads/hslide/'.$slide->image?>" alt="<?=$slide->title?>" title="#slider-direction-<?=$i?>"  />
            <?endforeach;?>
		</div>
		<!-- direction 1 -->
        <?$i=0;foreach($hslide as $slide):$i++;?>
		<div id="slider-direction-<?=$i?>" class="t-cn slider-direction">
			<div class="slider-content t-cn s-tb slider-1">
				<div class="title-container s-tb-c title-compress">
					<h4 class="title4" ><?=$slide->title?></h4>
					<p><?=$slide->caption?></p>
				</div>
			</div>	
		</div>
        <?endforeach;?>
	</div>
</div>
<!-- Slider area End here  -->
<?endif;?>
<div class="get-free-consultation-area small">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<div class="get-free-consultation-text">
					<p>Nếu bạn còn băn khoăn về thiết kế xây dựng ... Hãy đến với chúng tôi</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="get-free-consultation-button">
					<a href="<?=PREFIX.'lien-he.html'?>">Liên hệ</a>
				</div>
				
			</div>
		</div>
	</div>
</div>
<section class="news-section">
    <div class="container">
        <?foreach($service as $sv):
        if(!empty($sv->list)):
        ?>
        <div class="news-box">
            <h3 class="news-head"><?=$sv->name?></h3>
            <div class="row">
                <?
                foreach($sv->list as $item):?>
                <div class="col-md-3 col-sm-6">
                    <div class="news-post">
                        <a href="<?=PREFIX.$item->slug.'.html'?>">
                        <img src="<?=PREFIX.'uploads/news/thumb/'.$item->thumb?>" alt="<?=$item->title?>" class="imglink lazy" style="display: inline;"></a>
                        <h4><a href="<?=PREFIX.$item->slug.'.html'?>"><?=$item->title?></a></h4>
                        <!--<span>Ngày: <?=date('d-m-Y',$item->time_create)?></span>-->
                        <!--<p></p>
                        <br /><a href="<?=PREFIX.$item->slug.'.html'?>">Xem thêm...</a>-->
                    </div>
                </div>
                <?endforeach;
                ?>              
            </div>
        </div>
        <?
        endif;
        endforeach;?>
    </div>
</section>

<!-- Latest Project Area Start Here -->
<div class="home-page-recent-news-area home-latest-project">
	<div class="home-page-team-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="section-title-area">
						<h2>Dự án hoàn thành</h2>
					</div>
				</div>
				<div class="project_solve">
					
					<?if(isset($project)):
                    foreach($project as $p):
                    ?>
                    <div class="total-single-team-area">
					<div class="single-project">
						<a href="<?=PREFIX.$p->slug.'.html'?>">
                        <img src="<?=PREFIX.'uploads/news/thumb/'.$p->thumb?>" alt="<?=$p->title?>">
                        </a>
						<div class="project-overley">
							<div class="content">
								<h3><a href="<?=PREFIX.$p->slug.'.html'?>"><?=$p->title?></a></h3>
                                <p class="meta"><?=date('d-m-Y',$p->time_create)?></p>
								<p class="news-content"><?=$p->caption?></p>					
							</div>
							<div class="link">
								<a href="<?=PREFIX.$p->slug.'.html'?>"> Chi tiêt</a>
							</div>
						</div>
					</div>
					</div>
					<?
                    endforeach;
                    endif;?>
					
				</div>
			</div>
		</div>

	</div>				
</div>
<!-- Latest Project Area End Here -->

<!-- About Company Section Start Here -->
<div class="about-company-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="box-image">
					<div class="single-area">
						<img src="<?=PREFIX.'uploads/news/'.$about->thumb?>" alt="<?=$about->title?>">
					</div>
				</div>
				<div class="content-area">
					<h3><a href="<?=PREFIX.'gioi-thieu.html'?>">Giới thiệu</a></h3>
					<p><?=$about->caption?></p>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="our-capability-area">
					<h3>Nhận xét của khách hàng</h3>
					<div class="panel-group main-service" id="accordion1" role="tablist" aria-multiselectable="true">
                        <?if(isset($feedback)): $i=0;
                        foreach($feedback as $f): $i++;
                        ?>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne<?=$i?>">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion<?=$i?>" href="#collapseOne<?=$i?>" aria-expanded="<?=($i==1)?'true':'false';?>" aria-controls="collapseOne">
                                    <?=$f->name?>
										<span class="heading-arrow"> 
											<i class="fa fa-angle-down" aria-hidden="true"></i>
										</span>
									</a>
								</h4>
							</div>
							<div id="collapseOne<?=$i?>" class="panel-collapse collapse <?=($i==1)?'in':'';?>" role="tabpanel" aria-labelledby="headingOne<?=$i?>">
								<div class="panel-body">
									<?=$f->feedback?>
								</div>
							</div>
						</div>
						<?
                        endforeach;
                        endif;
                        ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Home Page Video Section Start Here -->
<div class="home-page-video-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
				<div class="video-content">
					<?=isset($caption_video)?$caption_video->content:""?>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="video-content">
                    <?if(isset($videos)):
                    foreach($videos as $v):
                    ?>
                    <div class="col-md-6 col-xs-12 video-item">
                        <iframe style="width: 100%; height: 100%!important;" src="https://www.youtube.com/embed/<?=$v->url?>?autoplay=0"></iframe>
                    </div>
                    <?
                    endforeach;
                    endif;
                    ?>
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Home Page Video Section End Here -->
<!-- Recent News Section Start Here -->
<?if(isset($news)):?>
<div class="home-page-recent-news-area">
	<div class="home-page-team-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="section-title-area">
						<h2>Tin tức nổi bật</h2>
					</div>
				</div>
				<div class="home-page-team">
                    <?
                    foreach($news as $p):
                    ?>
					<div class="total-single-team-area">
						<div class="single-team-area">
							<a href="<?=PREFIX.$p->slug.'.html'?>">
                            <img src="<?=PREFIX.'uploads/news/thumb/'.$p->thumb?>" alt="<?=$p->title?>"></a>
							<div class="overley">
								<ul>
								   <li><a href="<?=PREFIX.$p->slug.'.html'?>"><i class="fa fa-link"></i></a></li>
								</ul>
							</div>														
						</div>
						<div class="content">
							<h3><a href="<?=PREFIX.$p->slug.'.html'?>"><?=$p->title?></a></h3>
							<p class="meta"><?=date('d-m-Y',$p->time_create)?></p>
							<p class="news-content"><?=$p->caption?></p>							
						</div>
					</div>
				    <?
                    endforeach;
                    ?>
				</div>
			</div>
		</div>

	</div>				
</div>
<?endif;?>
<!-- Recent News Section End Here -->
<!-- Client Logo Area Section start here -->
<?if($brands):?>
<div class="container">	
	<div class="client-logo-area">
        <?foreach($brands as $b):?>						
		<div class="single-logo"><a target="_blank" href="<?=$b->link?>">
        <img src="<?=PREFIX.'uploads/brands/'.$b->thumb?>" alt="<?=$b->name?>"></a></div>
		<?endforeach;?>
	</div>
</div>
<?endif;?>
<!-- Client Logo Area Section End here -->
<!-- Free Consultation Area Start here -->
<div class="get-free-consultation-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<div class="get-free-consultation-text">
					<p><?=isset($slogan)?$slogan->content:""?></p>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="get-free-consultation-button">
					<a href="<?=PREFIX.'lien-he.html'?>">Liên hệ</a>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- Free Consultation Area End here -->
<!-- Google Map Integrate Start Here -->
<!--<div class="google-map-area">
	<div id="googleMap" style="width:100%;height:500px;"></div>
</div>
<!-- Google Map Integrate End Here -->
		
