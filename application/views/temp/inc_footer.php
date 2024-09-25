<!-- Footer Area Section Start Here -->
		<footer>
			<div class="footer-top-area">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="single-footer footer-one">
								<h3>Menu</h3>
								<div class="menu-footer">
									<nav>
										<ul>
											<li><a href="<?=PREFIX?>">Trang chủ</a></li>
											<li><a href="<?=PREFIX?>gioi-thieu.html">Giới thiệu</a></li>
											<li><a href="<?=PREFIX?>tu-van-thiet-ke.html">Tư vấn thiết kế</a></li>
											<li><a href="<?=PREFIX?>tin-tuc.html">Tin tức</a></li>
											<li><a href="<?=PREFIX?>lien-he.html">Liên hệ</a></li>
										</ul>
									</nav>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="single-footer footer-two">
								<h3>Dịch vụ</h3>
								<nav>
									<ul>
										<?if(isset($cat_sv)):
                                        foreach($cat_sv as $c):?>
										<li>			
											<a href="<?=PREFIX.'dich-vu/'.$c->slug?>"><?=$c->name?></a>		
										</li>	
										<?endforeach;
                                        endif;
                                        ?>
									</ul>
								</nav>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="single-footer footer-three">
								<div class="fb-page" data-href="<?=isset($info[1])?$info[1]->content:'https://www.facebook.com/xaydungtinduc/'?>" data-tabs="timeline" data-width="500" data-height="190" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"></div>
							</div>
						</div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="single-footer footer-four">
								<h3>Liên hệ</h3>
								<nav>
									<ul>
										<li><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?=isset($info[3])?$info[3]->content:''?></li>
										<li><i class="fa fa-phone" aria-hidden="true"></i> <?=isset($info[0])?$info[0]->content:''?></li>
										<li><i class="fa fa-envelope-o" aria-hidden="true"></i> <?=isset($info[2])?$info[2]->content:''?></li>
										<!--<li><i class="fa fa-fax" aria-hidden="true"></i> Fax: (123) 118 9999</li>-->
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-bottom-area">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="footer-bottom">
								<p> &copy; Copyright  Xaydungtinduc.com 2016. All Right Reserved.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="hidden" id="prefix"><?=PREFIX?></div>
            <a class="call_icon" href="tel:<?=isset($info[0])?$info[0]->content:''?>">
                <img src="<?=PREFIX?>images/call.gif" alt="Call Now <?=TITILE?>" width="70"/>
            </a>
            <a class="call_icon" href="https://zalo.me/<?=isset($info[0])?str_replace(' ','',$info[0]->content):'0933946869'?>" style="left: 100px;">
                <img src="<?=PREFIX?>images/zalo.png" alt="Zalo for me" width="70">
            </a>
		</footer>
		<!-- Footer Area Section End Here -->
       </div>       
		<!-- JS -->
		<div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6&appId=1543596855930468";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
		<!-- jquery js -->
        <script src="<?=PREFIX?>js/vendor/jquery-1.11.2.min.js"></script>
		
		<!-- bootstrap js -->
        <script src="<?=PREFIX?>js/bootstrap.min.js"></script>
		
		<!-- owl.carousel.min js -->
        <script src="<?=PREFIX?>js/owl.carousel.js"></script>
		
		<!-- slicknav js -->
        <script src="<?=PREFIX?>js/jquery.meanmenu.min.js"></script>

		<!-- jquery.collapse js -->
        <script src="<?=PREFIX?>js/jquery.collapse.js"></script>
		
		<!-- jquery.easing js -->
        <script src="js/jquery.easing.1.3.min.js"></script>	
		
		<!-- jquery.scrollUp js -->
        <script src="<?=PREFIX?>js/jquery.scrollUp.min.js"></script>

		<!-- Nivo slider js --> 		
		<script src="<?=PREFIX?>lib/custom-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
		<script src="<?=PREFIX?>lib/custom-slider/home.js" type="text/javascript"></script>

	   <!-- 	Fancybox js -->      
        <script src="<?=PREFIX?>lib/fancybox/jquery.fancybox.pack.js"></script>
        
		<!-- wow js -->
        <script src="<?=PREFIX?>js/wow.js"></script>		
		<script>
			new WOW().init();
		</script>   
		<!-- Google Map js -->
        <script src="https://maps.googleapis.com/maps/api/js"></script>
       
		<!-- plugins js -->
        <script src="<?=PREFIX?>js/plugins.js"></script>
		
		<!-- main js -->
        <script src="<?=PREFIX?>js/main.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123342250-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-123342250-1');
</script>
    </body>
</html>