
<?if(isset($hslide)):?>
	<!-- Slider area End here  -->
	<div id="slider" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<?$i=0;foreach($hslide as $slide):$i++;?>
				<div class="carousel-item <?= ($i == 1) ? 'active' : '' ?>">
					<img src="<?=PREFIX.'uploads/hslide/'.$slide->image?>" alt="<?=$slide->title?>" title="#slider-direction-<?=$i?>" class="d-block w-100">
					<div class="carousel-caption d-block">
						<h5><?=$slide->title?></h5>
						<p><?=$slide->caption?></p>
						<button class="btn btn-main">Get A Quate</button>
					</div>
				</div>
			<?endforeach;?>
		</div>
		<a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
			<i class="fa fa-chevron-left"></i>
		</a>
		<a class="carousel-control-next" href="#slider" role="button" data-slide="next">
			<i class="fa fa-chevron-right"></i>
		</a>
	</div>
<?endif;?>

<?foreach($service as $sv):
	if(!empty($sv->list)):?>
	<div class="news pt-5">
		<div class="container">
			<h3 class="news-head"><?=$sv->name?></h3>
			<div class="row">
			<?foreach($sv->list as $item):?>
				<div class="item col-sm-6 col-md-4 d-flex flex-column mb-5">
					<img src="<?=PREFIX.'uploads/news/thumb/'.$item->thumb?>" alt="<?=$item->title?>">
					<h1 class="mt-4"></h1>
					<p><?=$item->title?></p>
					<a href="<?=PREFIX.$item->slug.'.html'?>" class="button"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				</div>
				<?endforeach; ?>            
			</div>
		</div>
	</div>
<?endif;
endforeach;?>

<div class="news pt-5">
        <div class="container">
            <h3 class="news-head">Dự án hoàn thành</h3>
            <div class="row">
            <?foreach($project as $item):?>
                <div class="item col-sm-4 col-md-3 d-flex flex-column mb-5" style="align-items: start; height: 550px; margin-bottom: 70px">
                    <div class="">
                        <img src="<?=PREFIX.'uploads/news/thumb/'.$item->thumb?>" alt="<?=$item->title?>" style="height: auto; max-height: 270px">
                        <p class="mt-4 title-new"><?=$item->title?></p>
                        <p style="text-align: left; width: 100%"><?=date('d-m-Y',$item->time_create)?></p>
                    </div>
                    <div class="border"></div>
                    <div style="overflow: hidden">
                        <p style="text-align: left; max-height: 80px;overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    line-height: 20px;"><?=$item->caption?></p>
                    </div>
                    <a href="<?=PREFIX.$item->slug.'.html'?>" class="button"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                </div>
                <?endforeach; ?>            
            </div>
        </div>
    </div>

<div class="review container mt-5 pb-4">
    <div class="info-company d-flex justify-content-center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
    </div>
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
        <?if(isset($feedback)): $i=0; ?>
            <div class="carousel-inner">
                <!-- Các items -->
                <?php $i = 0; $count = count($feedback); ?>
                <?php foreach ($feedback as $index => $f): ?>
                    <?php if ($i % 3 == 0): // Mở slide mới sau mỗi 3 items ?>
                        <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                            <div class="testimonial-wrapper d-flex justify-content-center">
                    <?php endif; ?>
                    
                    <!-- Nội dung testimonial -->
                    <div class="testimonial-card text-center mx-2 d-flex flex-column align-items-center">
                        <div style="flex: 1 1 auto">
                            <img src="https://via.placeholder.com/80" alt="Avatar" class="rounded-circle mb-3">
                            <h5><?= $f->name ?></h5>
                            <!-- <p class="text-muted"><?= $f->position ?? 'Position, Company' ?></p> -->
                            <p><?= $f->feedback ?></p>
                        </div>
                        <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                    </div>
                    
                    <?php $i++; ?>
                    <?php if ($i % 3 == 0 || $i == $count): // Đóng slide sau mỗi 3 items hoặc ở cuối ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?endif;?>
        <!-- Controls -->
        <button class="carousel-control-prev control-slide-preview" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </button>
        <button class="carousel-control-next control-slide-preview" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
            <i class="fa fa-chevron-right"></i>
        </button>
    </div>
</div>
<div class="exp container mt-5 pb-4">
    <div class="row">
        <!-- <div class="col-md-6">
            <img src="" alt="">
        </div> -->
        <div class="col-md-6">
            <div class="introduce">
                <div class="title">
                    <span class="fw-bold">We have 32+</span>
                    <span>Years Of Business Experiences</span>
                </div>
                <img src="https://novaly.windstripedesign.ro/images/objects/1.png" alt="">
            </div>
            <div class="mt-5">
                <p class="color-main">
                    <?=isset($caption_video)?$caption_video->content:""?>
                </p>
                
                <!-- <img class="signature" src="https://novaly.windstripedesign.ro/images/about/signature.png" alt="">
                <br>
                <button class="btn btn-main mt-4" onclick="">VỀ CHÚNG TÔI</button> -->
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
    <div class="row info mt-4">
        <div class=" col-md-3 col-sm-6">
            <div class="item">
                <p class="number number-1">1450</p>
                <p class="text">Happy Customers</p>
            </div>
        </div>
        <div class=" col-md-3 col-sm-6">
            <div class="item">
                <p class="number number-2">1450</p>
                <p class="text">Happy Customers</p>
            </div>
        </div>
        <div class=" col-md-3 col-sm-6">
            <div class="item">
                <p class="number number-3">1450</p>
                <p class="text">Happy Customers</p>
            </div>
        </div>
        <div class=" col-md-3 col-sm-6">
            <div class="item">
                <p class="number number-4">1450</p>
                <p class="text">Happy Customers</p>
            </div>
        </div>
    </div>
    <div class="mt-5"></div>
</div>
<div class="services">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 title">
                <p class="color-main font-w-bold">Service We Offer</p>
                <p class="font-s-max font-w-bold">Our Services</p>
            </div>
            <div class="col-md-6 col-sm-6 content">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos aperiam porro necessitatibus, consequuntur, reiciendis dolore doloribus id repellendus tempora vitae quia voluptas ipsum eligendi hic.</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-3 col-sm-6">
                <div class="box">
                    <span class="img">
                        <img src="https://novaly.windstripedesign.ro/images/bg/1.jpg" alt="">
                    </span>
                    <div class="d-flex flex-column align-items-center">
                        <div class="service-icon">
                            <span class="service-1"></span>
                        </div>
                        <div class="service-content">
                            <h3 class="font-w-bold">Online Business</h3>
                            <p>We always provide people a complete solution focused of any business.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="box">
                    <span class="img">
                        <img src="https://novaly.windstripedesign.ro/images/bg/1.jpg" alt="">
                    </span>
                    <div class="d-flex flex-column align-items-center">
                        <div class="service-icon">
                            <span class="service-2"></span>
                        </div>
                        <div class="service-content">
                            <h3 class="font-w-bold">Human Resource</h3>
                            <p>We always provide people a complete solution focused of any business.</p>
                        </div>
                    </div>
                </div>
            </div><div class="col-md-3 col-sm-6">
                <div class="box">
                    <span class="img">
                        <img src="https://novaly.windstripedesign.ro/images/bg/1.jpg" alt="">
                    </span>
                    <div class="d-flex flex-column align-items-center">
                        <div class="service-icon">
                            <span class="service-3"></span>
                        </div>
                        <div class="service-content">
                            <h3 class="font-w-bold">Market Research</h3>
                            <p>We always provide people a complete solution focused of any business.</p>
                        </div>
                    </div>
                </div>
            </div><div class="col-md-3 col-sm-6">
                <div class="box">
                    <span class="img">
                        <img src="https://novaly.windstripedesign.ro/images/bg/1.jpg" alt="">
                    </span>
                    <div class="d-flex flex-column align-items-center">
                        <div class="service-icon">
                            <span class="service-4"></span>
                        </div>
                        <div class="service-content">
                            <h3 class="font-w-bold">Business Strategy</h3>
                            <p>We always provide people a complete solution focused of any business.</p>
                        </div>
                    </div>
                </div>
            </div><div class="col-md-3 col-sm-6">
                <div class="box">
                    <span class="img">
                        <img src="https://novaly.windstripedesign.ro/images/bg/1.jpg" alt=""> 
                    </span>
                    <div class="d-flex flex-column align-items-center">
                        <div class="service-icon">
                            <span class="service-5"></span>
                        </div>
                        <div class="service-content">
                            <h3 class="font-w-bold">Project Managment</h3>
                            <p>We always provide people a complete solution focused of any business.</p>
                        </div>
                    </div>
                </div>
            </div><div class="col-md-3 col-sm-6">
                <div class="box">
                    <span class="img">
                        <img src="https://novaly.windstripedesign.ro/images/bg/1.jpg" alt="">
                    </span>
                    <div class="d-flex flex-column align-items-center">
                        <div class="service-icon">
                            <span class="service-6"></span>
                        </div>
                        <div class="service-content">
                            <h3 class="font-w-bold">Money Management</h3>
                            <p>We always provide people a complete solution focused of any business.</p>
                        </div>
                    </div>
                </div>
            </div><div class="col-md-3 col-sm-6">
                <div class="box">
                    <span class="img">
                        <img src="https://novaly.windstripedesign.ro/images/bg/1.jpg" alt="">
                    </span>
                    <div class="d-flex flex-column align-items-center">
                        <div class="service-icon">
                            <span class="service-7"></span>
                        </div>
                        <div class="service-content">
                            <h3 class="font-w-bold">Online Marketing</h3>
                            <p>We always provide people a complete solution focused of any business.</p>
                        </div>
                    </div>
                </div>
            </div><div class="col-md-3 col-sm-6">
                <div class="box">
                    <span class="img">
                        <img src="https://novaly.windstripedesign.ro/images/bg/1.jpg" alt="">
                    </span>
                    <div class="d-flex flex-column align-items-center">
                        <div class="service-icon">
                            <span class="service-8"></span>
                        </div>
                        <div class="service-content">
                            <h3 class="font-w-bold">Business Insurance</h3>
                            <p>We always provide people a complete solution focused of any business.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?if(isset($news)):?>
    <div class="news pt-5">
        <div class="container">
            <h3 class="news-head">Tin tức nổi bật</h3>
            <div class="row">
            <?foreach($news as $item):?>
                <div class="item col-sm-4 col-md-3 d-flex flex-column mb-5" style="align-items: start; height: 550px; margin-bottom: 70px">
                    <div class="">
                        <img src="<?=PREFIX.'uploads/news/thumb/'.$item->thumb?>" alt="<?=$item->title?>" style="height: auto; max-height: 270px">
                        <p class="mt-4 title-new"><?=$item->title?></p>
                        <p style="text-align: left; width: 100%"><?=date('d-m-Y',$item->time_create)?></p>
                    </div>
                    <div class="border"></div>
                    <div style="overflow: hidden">
                        <p style="text-align: left; max-height: 80px;overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    line-height: 20px;"><?=$item->caption?></p>
                    </div>
                    <a href="<?=PREFIX.$item->slug.'.html'?>" class="button"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                </div>
                <?endforeach; ?>            
            </div>
        </div>
    </div>
<?endif;?>
        <div class="contact-us">
            <div class="container">
                <div class="row">
                    <div class="video d-flex justify-content-center col-md-7 order-sm-2 order-xs-2">
                        <a class="play" href="">
                            <i class="fa fa-play-circle" aria-hidden="true"></i>
                            <span class="effect"></span>
                        </a>
                    </div>
                    <div class="form col-md-5 order-sm-1 order">
                        <div class="callback">
                            <div class="header">
                                <h3>Feel Free to Contact Us</h3>
                                <p>Distinctively exploit optimal alignments for intuitive coordinate business applications technologies</p>
                            </div>
                            <div class="content-form mt-5">
                                <form action="">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="Email" required="required">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject" required="required">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="message" placeholder="Message" rows="4" class="form-control" id=""></textarea>
                                    </div>
                                    <div class="btn-submit">
                                        <button>Request FOR SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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