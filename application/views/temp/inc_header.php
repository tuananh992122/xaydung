<!doctype html>
<html class="no-js" lang="vi">
    <head>
		<!-- Basic page needs
		============================================ -->	
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?=isset($seo_desc)?$seo_desc:DESCRIPTION?>"/>
        <meta name="keywords" content="<?=isset($seo_key)?$seo_key:KEYWORDS?>"/>
        <title><?=isset($seo_title)?$seo_title:TITLE?></title>
		
		<!-- Mobile specific metas
		============================================ -->		
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Favicon
		============================================ -->
		<link rel="shortcut icon" type="image/x-icon" href="<?=PREFIX?>img/fav_icon.ico">

		<!-- CSS  -->
		
		<!-- Bootstrap CSS
		============================================ -->
        <link rel="stylesheet" href="<?=PREFIX?>css/bootstrap.min.css">
		
		<!-- font-awesome CSS
		============================================ -->
        <link rel="stylesheet" href="<?=PREFIX?>css/font-awesome.min.css">
		
		<!-- Flat Icon CSS
		============================================ -->
        <link rel="stylesheet" href="<?=PREFIX?>css/flaticon.css">
		
		<!-- owl.carousel CSS
		============================================ -->
        <link rel="stylesheet" href="<?=PREFIX?>css/owl.carousel.css">
        <link rel="stylesheet" href="<?=PREFIX?>css/owl.theme.css">
        <link rel="stylesheet" href="<?=PREFIX?>css/owl.transitions.css">
		
		<!-- animate CSS
		============================================ -->
        <link rel="stylesheet" href="css/animate.css">
		
		<!-- slicknav CSS
		============================================ -->		
        <link rel="stylesheet" href="<?=PREFIX?>css/meanmenu.min.css">
		
		<!-- normalize CSS
		============================================ -->		
        <link rel="stylesheet" href="<?=PREFIX?>css/normalize.css">
		
		<!-- main CSS
		============================================ -->		
        <link rel="stylesheet" href="<?=PREFIX?>css/main.css">
		
		<!-- nivo slider CSS
		============================================ -->
		<link rel="stylesheet" href="<?=PREFIX?>lib/custom-slider/css/nivo-slider.css" type="text/css" />
		<link rel="stylesheet" href="<?=PREFIX?>lib/custom-slider/css/preview.css" type="text/css" media="screen" />
		
		<!-- Fancybox css -->
		<link rel="stylesheet" href="<?=PREFIX?>lib/fancybox/jquery.fancybox.css">

		<!-- style CSS
		============================================ -->			
        <link rel="stylesheet" href="<?=PREFIX?>css/style_theme.css">
		
		<!-- responsive CSS
		============================================ -->			
        <link rel="stylesheet" href="<?=PREFIX?>css/responsive.css">
		
		<!-- modernizr js
		============================================ -->		
        <script src="<?=PREFIX?>js/vendor/modernizr-2.8.3.min.js"></script>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16636822391"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'AW-16636822391');
        </script>
        <!-- Global site tag (gtag.js) - Google Ads: 859377409 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-859377409"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'AW-859377409');
        </script>
        <!-- Event snippet for Lượt truy cập trang conversion page -->
        <script>
            gtag('event', 'conversion', {'send_to': 'AW-859377409/HaDSCLm8ztYBEIGe5JkD'});
        </script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-T7QT4XP');</script>
        <!-- End Google Tag Manager -->
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-G6GN3CFQ9M"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-G6GN3CFQ9M');
        </script>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16523386129"></script>
        <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-16523386129'); </script>
    </head>
    <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T7QT4XP"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		<div class="wrapper-area">
        <!-- start header area here --> 
        <header>      
        	<div class="header-area" id="sticker">
				<div class="container">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
							<div class="logo-area">							
							<a href="<?=PREFIX?>"><img src="<?=PREFIX?>img/logo1.png" alt="<?=TITLE?>"></a>
							</div>				
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<div class="main-menu-area">							
								<nav>
									<ul>
										<li><a href="<?=PREFIX?>" <?=(isset($module) && $module == 'home')?'class="active"':''?>>Trang chủ</a></li>
										<li><a href="<?=PREFIX?>gioi-thieu.html" <?=(isset($module) && $module == 'about')?'class="active"':''?> >Giới thiệu</a></li>
										
                                        <?if(isset($cat_sv)):
                                            foreach($cat_sv as $c):?>
											<li>			
												<a href="<?=PREFIX.'dich-vu/'.$c->slug?>"><?=$c->name?></a>
                                                <?if(!empty($c->child)):
                                                echo '<ul class="sub-menu">';
                                                foreach($c->child as $child):?>	
                                                <li>
                                                <a href="<?=PREFIX.'dich-vu/'.$child->slug?>"><?=$child->name?></a>
                                                </li>
                                                <?endforeach;
                                                echo '</ul>';
                                                endif;?>		
											</li>	
											<?endforeach;
                                            endif;
                                            ?>
                                        <li><a href="javascript:void(0)" <?=(isset($module) && $module == 'service')?'class="active"':''?>>Dịch vụ khác</a>
											<ul>
                                                <?if(isset($cat_sv_o)):
                                                foreach($cat_sv_o as $co):?>
    											<li>			
    												<a href="<?=PREFIX.'dich-vu/'.$co->slug?>"><?=$co->name?></a>
                                                    <?if(!empty($co->child)):
                                                    echo '<ul class="sub-menu">';
                                                    foreach($co->child as $ochild):?>	
                                                    <li>
                                                    <a href="<?=PREFIX.'dich-vu/'.$ochild->slug?>"><?=$ochild->name?></a>
                                                    </li>
                                                    <?endforeach;
                                                    echo '</ul>';
                                                    endif;?>		
    											</li>	
    											<?endforeach;
                                                endif;
                                                ?>															
											</ul>                                       
										</li>
										<!--<li><a href="<?=PREFIX?>dich-vu/tu-van-thiet-ke">Tư vấn thiết kế</a></li></li>-->
										<!--<li><a <?=(isset($module) && $module == 'news')?'class="active"':''?> href="<?=PREFIX?>tin-tuc.html" >Tin tức</a></li>-->
										<li><a <?=(isset($module) && $module == 'contact')?'class="active"':''?> href="<?=PREFIX?>lien-he.html">Liên hệ</a></li>
									</ul>
								</nav>
							</div>				
						</div>
						<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
							<div class="search-box-area">
								<div class="search-box">
									<form id="searchform" class="searchform" method="post" action="" onsubmit="return do_search();">
										<input type="text" id="txt_search" class="search-text" value="<?=isset($keyword)?$keyword:''?>" placeholder="Search......" required>									
										<a href="javascript:void(0)" onclick="return do_search();" class="search-button"><i class="fa fa-search" aria-hidden="true"></i></a>
									</form>
								</div>
							</div>
						</div>		
					</div>
				</div>
			</div>
			<!-- mobile-menu-area start -->
			<div class="mobile-menu-area">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="mobile-menu">
								<nav id="dropdown">
									<ul>
										<li><a href="<?=PREFIX?>" class="active">Trang chủ</a></li>
										<li><a href="<?=PREFIX?>gioi-thieu.html" >Giới thiệu</a></li>
                                        <?if(isset($cat_sv)):
                                            foreach($cat_sv as $c):?>
											<li>			
												<a href="<?=PREFIX.'dich-vu/'.$c->slug?>"><?=$c->name?></a>
                                                <?if(!empty($c->child)):
                                                echo '<ul class="sub-menu">';
                                                foreach($c->child as $child):?>	
                                                <li>
                                                <a href="<?=PREFIX.'dich-vu/'.$child->slug?>"><?=$child->name?></a>
                                                </li>
                                                <?endforeach;
                                                echo '</ul>';
                                                endif;?>		
											</li>	
											<?endforeach;
                                            endif;
                                            ?>
                                        <?if(isset($cat_sv_o)):
                                            foreach($cat_sv_o as $co):?>
											<li>			
												<a href="<?=PREFIX.'dich-vu/'.$co->slug?>"><?=$co->name?></a>
                                                <?if(!empty($co->child)):
                                                echo '<ul class="sub-menu">';
                                                foreach($co->child as $ochild):?>	
                                                <li>
                                                <a href="<?=PREFIX.'dich-vu/'.$ochild->slug?>"><?=$ochild->name?></a>
                                                </li>
                                                <?endforeach;
                                                echo '</ul>';
                                                endif;?>		
											</li>	
											<?endforeach;
                                            endif;
                                            ?>	
										<!--<li><a href="#">Dịch vụ</a><ul></ul></li>-->
										<!--<li><a href="service.html">Tư vấn thiết kế</a></li></li>-->
										<!--<li><a href="<?=PREFIX?>tin-tuc.html" >Tin tức</a></li>-->
										<li><a href="<?=PREFIX?>lien-he.html">Liên hệ</a></li>
									</ul>
								</nav>
							</div>					
						</div>
					</div>
				</div>
			</div>
			<!-- mobile-menu-area end -->
		</header>
       <!-- end header area here -->