 <!-- Page Header Section Start Here -->
<div class="page-header-area">
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="header-page">
				<h2>Liên hệ</h2>
				<ul>
					<li> <a href="<?=PREFIX?>">Trang chủ</a> </li>
					<li>Liên hệ</li>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<!-- Page Header Section End Here -->
<!-- Main Contact Page Section Area start here-->
<div class="main-contact-page-area">

<div class="container">
	<div class="contact-text">
		<h3>Liên hệ</h3>
		<p>Hãy gọi hoặc điền vào mẫu thông tin bên dưới. Chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất.</p>
	</div>
</div>
<!-- Google Map Integrate End Here -->       	
</div>
<!-- Main Contact Page Section Area End here-->

<!-- Contact Form Page start Here -->
<div class="main-conatct-form-area">
<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            <?if(isset($_GET["msg"]) && $_GET["msg"] == "success"):?>
              <div id="thongbao" class="alert alert-success">Thông tin liên hệ đã được gửi thành công.</div>
            <?endif;?>
 				<div class="main-contact-form">         					
 					<form method="POST" onsubmit="return do_contact();" action="<?=PREFIX.'lien-he.html'?>" id="contact">
 						<fieldset>
 						<div class="col-sm-6 padding-left">
 							<div class="form-group">
 								<input name="name" id="name_contact" type="text" class="form-control txt_contact" placeholder="Họ và tên" />
 							</div>
 						</div>
                        <div class="col-sm-6 padding-right">
 							<div class="form-group">
 								<input name="mobile" type="text" id="phone_contact" class="form-control txt_contact" placeholder="Số điện thoại" />
 							</div>
 						</div>
                        <div class="col-sm-6 padding-left">
 							<div class="form-group">
 								<input name="email" id="email" type="text" class="form-control txt_contact" placeholder="Email" />
 							</div>
 						</div>
                        <div class="col-sm-6 padding-right">
 							<div class="form-group">
 								<input name="address" type="text" id="address" class="form-control txt_contact" placeholder="Địa chỉ" />
 							</div>
 						</div>
 						<div class="col-sm-12 acurate">
 							<div class="form-group">
                                <textarea cols="40" rows="10" name="content" id="content_contact" class="textarea form-control txt_contact" placeholder="Nội dung"></textarea>
 							</div>
 						</div>
 						<div class="col-sm-12 acurate">
 							<div class="form-group">
 								<button class="btn-send" type="submit">Gửi yêu cầu</button>
                                <input id="prefix" type="hidden" value="<?=PREFIX?>" /> 
 							</div>
 						</div>
 						</fieldset>
 					</form>
 				</div>
		</div>       			
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="page-sidebar-area">
				<div class="single-sidebar">
					<h3>Liên hệ</h3>
					<nav>
						<ul>
							<li><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Số 80/32/10 Đường Gò Dầu, P. Tân Quý, Q. Tân Phú, THCM</li>
							<li><i class="fa fa-phone" aria-hidden="true"></i> 0933 94 68 69</li>
							<li><i class="fa fa-envelope-o" aria-hidden="true"></i> xaydungtinduc@gmail.com</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
        <!-- Google Map Integrate Start Here 
        <div class="clearfix"></div>
        <div class="google-map-area">
        	<div class="container">
        	   <div id="googleMap" style="width:100%;height:450px;"></div>				
        	</div>
        </div>-->
	</div>
</div>
</div>
<!-- Contact Form Page start Here -->
<!-- Free Consultation Area Start here -->
<!--<div class="get-free-consultation-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<div class="get-free-consultation-text">
					<p>If you have any Construction problem ... We are available</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="get-free-consultation-button">
					<a href="contact.html">Get Free Consultation</a>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- Free Consultation Area End here -->