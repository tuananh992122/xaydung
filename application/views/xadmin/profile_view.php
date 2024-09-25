<?if(isset($action) && $action == "yourself"):?>
<script type="text/javascript">
function profile_update(){
    var name = $('#name').val();
    var mobile = $('#mobile').val();
    if(name == '' || mobile == ''){
        $('.alert').show().html('Họ tên và SĐT không được để trống');
        return false;
    }
    var pass = $('#password').val();
    var pass2 = $('#password2').val();
    if(pass != ''){
        if(pass.length < 6){
            $('.alert').show().html('Mật khẩu phải lớn hơn hoặc bằng 6 kí tự');
            return false;
        }
        if(pass != pass2){
            $('.alert').show().html('Mật khẩu xác nhận không đúng');
            return false;
        }    
    }    
}
</script>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Tài khoản cá nhân
            </header>
            <div class="panel-body">
                <?if(isset($thongbao)){?><div class="alert alert-success"><?=$thongbao?></div><?}?>
                <form class="form-horizontal bucket-form" method="post" onsubmit="return profile_update();" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="true" class="form-control" value="<?=isset($row)?$row->username:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="true" class="form-control" value="<?=isset($row)?$row->email:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Họ tên</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="name" id="name" value="<?=isset($row)?$row->name:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SĐT</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?=isset($row)?$row->mobile:""?>" name="mobile" id="mobile"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Mật khẩu mới</label>
                        <div class="col-sm-6">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Bỏ trống nếu không thay đổi"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Xác nhận mật khẩu</label>
                        <div class="col-sm-6">
                            <input type="password" name="password2" id="password2" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info">Xác nhận</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>"><i class="fa fa-long-arrow-left"></i> Hủy bỏ</a>
                            <div class="space10"></div>
                            <div class="alert alert-danger hidden"></div>
                            <input type="hidden" name="id" id="id" value="<?=isset($row)?$row->id:0?>"/>
                        </div>
                    </div>            
                </form>
            </div>
        </section>
    </div>
</div>

<?elseif(isset($action) && $action == "view"):?>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="#">Tài khoản cá nhân</a></li>
            <li class="active">Thành viên trong nhóm</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thành viên trong nhóm
            </header>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th class="center">No</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?$i=$offset; if(isset($rows))foreach($rows as $r){$i++;?> 
                      <tr>
                        <td class="center"><?=$i?></td>
                        <td><?=$r->username?></td>
                        <td><?=$r->name?></td>
                        <td><?=$r->email?></td>
                        <td><?=$r->mobile?></td>
                      </tr>   
                      <?}else{?>
                      <tr><td colspan="6"><div class="no_data">Không có dữ liệu</div></td></tr>  
                      <?}?>   
                      <tr><td colspan="8"><div class="paged"><?=(isset($pagi))?$pagi:""?></div></td></tr>  
                    </tbody>
                  </table>
            </div>    
        </section>
    </div>
</div>
    
<? endif; ?>
