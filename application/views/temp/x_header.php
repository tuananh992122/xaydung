<? if(!$this->session->userdata("admin_id")) redirect(XADMIN."/user/login"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />	
<title><?=isset($seo_title)?$seo_title:TITLE?></title>
<meta name="author" content="ntson1009"/>
<link rel="shortcut icon" href="<?=PREFIX?>admin/images/cpanel.png"/>
<!--Core CSS -->
<link href="<?=PREFIX?>admin/bootstrap.min.css" rel="stylesheet"/>
<link href="<?=PREFIX?>css/jquery-ui.css" rel="stylesheet"/>
<link href="<?=PREFIX?>admin/bootstrap-reset.css" rel="stylesheet"/>
<link href="<?=PREFIX?>admin/font-awesome/css/font-awesome.css" rel="stylesheet"/>
<!-- Custom styles for this template -->
<link href="<?=PREFIX?>admin/style.css" rel="stylesheet"/>
<link href="<?=PREFIX?>admin/style-responsive.css" rel="stylesheet"/>
<!--Core js-->
<script src="<?=PREFIX?>js/jquery_min.js"></script>
<script src="<?=PREFIX?>js/jquery-ui.js"></script>
<script src="<?=PREFIX?>js/common.js"></script>
<script src="<?=PREFIX?>admin/js/bootstrap.min.js"></script>
<script src="<?=PREFIX?>admin/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?=PREFIX?>admin/js/jquery.scrollTo.min.js"></script>
<script src="<?=PREFIX?>admin/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?=PREFIX?>admin/js/jquery.nicescroll.js"></script>
<script src="<?=PREFIX?>admin/js/scripts.js"></script>
<!-- File upload -->
<link href="<?=PREFIX?>admin/js/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet"/>
<script src="<?=PREFIX?>admin/js/bootstrap-fileupload/bootstrap-fileupload.js"></script>

</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="<?=CPANEL?>" class="logo">
         <img src="<?=PREFIX?>admin/images/logo.png" alt=""/> 
    </a>
</div>
<!--logo end-->
<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="<?=PREFIX?>admin/images/no_avatar.png"/>
                <span class="username"><?=$this->session->userdata("admin_user")?></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="<?=PREFIX?>" target="_blank"><i class="fa fa-home"></i>Website</a></li>
                <li><a href="<?=CPANEL?>/profile/yourself"><i class="fa fa-suitcase"></i>Tài khoản</a></li>
                <li><a href="<?=CPANEL?>/user/logout"><i class="fa fa-key"></i>Đăng xuất</a></li>
            </ul>
        </li>
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->

<!--sidebar start-->
<script type="text/javascript">
$(document).ready(function(){    
    var uri2 = '<?=isset($uri[2])?$uri[2]:""?>';
    if(uri2 == '' || uri2 == 'home')
        $('#li_a_dashboard').addClass('active');       
    //Acitve sub menu
    var uri3 = '<?=isset($uri[3])?$uri[3]:""?>';
    if(uri3 != ''){         
        $('#'+uri2+'_'+uri3).addClass('active');
        $('#'+uri2+'_'+uri3).parents('.sub-menu').find('a.dcjq-parent').addClass('active');
        $('#'+uri2+'_'+uri3).parents('.sub-menu').find('ul.sub').show();
        $('li[id^='+uri2+']').parents('.sub-menu').find('ul.sub').show();
    }else
        $('#li_a_dashboard').addClass('active');         
    return false;    
})
</script>
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a id="li_a_dashboard" href="<?=CPANEL?>">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?=$this->user->parse_menu_admin();?>       
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->

<!--main content start-->
<section id="main-content">
    <section class="wrapper">