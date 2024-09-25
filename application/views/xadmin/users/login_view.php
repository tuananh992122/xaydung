<? if($this->session->userdata("admin_id")) redirect(XADMIN); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content=""/>
    <meta name="author" content="ntson1009"/>
    <link rel="shortcut icon" href="images/favicon.png"/>    
    <title>Đăng nhập</title>    
    <!--Core CSS -->
    <link href="<?=PREFIX?>admin/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?=PREFIX?>admin/bootstrap-reset.css" rel="stylesheet"/>
    <link href="<?=PREFIX?>admin/font-awesome/css/font-awesome.css" rel="stylesheet" />    
    <!-- Custom styles for this template -->
    <link href="<?=PREFIX?>admin/style.css" rel="stylesheet"/>
    <link href="<?=PREFIX?>admin/style-responsive.css" rel="stylesheet" />    
    <!--Core js-->
    <script src="<?=PREFIX?>js/jquery_min.js"></script>
</head>
<style type="text/css">
#txt_code{width: 150px;float: left;margin-right: 15px;}
#imgcode{margin-top: 8px;}
#div_code{padding-top: 0;}
</style>
<body>
<script type="text/javascript">
function doLogin(){
    var prefix = $('#prefix').html();
    var user = $('#txt_username').val();
    var pass = $('#txt_password').val();
    var code = $('#txt_code').val();
    $.post(prefix+"/user/captcha",{code:code,fix:Math.random()},function(rt){
        if(rt == 1){
            $.post(prefix+"/user/do_login",{user:user,pass:pass,fix:Math.random()},function(rt){                                                            
                if(rt == 'success')
                    window.location.href=prefix;
                else{
                    alert('Tên đăng nhập hoặc mật khẩu không đúng.');
                    $('#imgcode').attr('src','<?=CPANEL?>/user/get_capcha?width=90&height=28&characters=5&_t=' + Math.random(1));
                }                                            
            })      
        }else{
            alert('Mã xác nhận không đúng');
            $('#imgcode').attr('src','<?=CPANEL?>/user/get_capcha?width=90&height=28&characters=5&_t=' + Math.random(1));
        }
            
    })               
    return false;
}
</script>

<body class="login-body">
    <div class="container">
      <form class="form-signin" action="" method="post" onsubmit="return doLogin();" autocomplete="off">
        <h2 class="form-signin-heading">Đăng nhập</h2>
        <div class="login-wrap">
            <div class="user-login-info">
                <input type="text" id="txt_username" class="form-control" placeholder="Tên đăng nhập" autofocus>
                <input type="password" id="txt_password" class="form-control" placeholder="Mật khẩu"/>
            </div>
            <div id="div_code" class="user-login-info">
                <input type="text" class="form-control" id="txt_code" name="code" placeholder="Mã an toàn"/>               
                <img id="imgcode" src="<?=CPANEL?>/user/get_capcha"/>
            </div>
            <button class="btn btn-lg btn-login btn-block" type="submit">Xác nhận</button>
        </div>
      </form>
    </div>
    <div id="prefix" class="hidden"><?=CPANEL?></div>
</body>
</html>