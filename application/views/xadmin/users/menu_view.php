<?if(isset($action) && $action == "list"):?>

<!-- Script -->
<script type="text/javascript">
function menu_del(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/ad_user/menu/delete',{id:id},function(rt){
        if(rt == 'success')
            $('#tr_'+id).remove();
        else if(rt == 'has_sub')
            alert('Bạn phải xóa các menu con trực thuộc trước khi xóa menu cấp 1 này');                
    });    
    return false;
}

function changeStatus(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/ad_user/menu/status',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
    })
}

</script>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="#">Thành viên quản trị</a></li>
            <li class="active">Menu chức năng</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Menu chức năng
            </header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/ad_user/menu/addedit" id="editable-sample_new" class="btn btn-primary btn-xs">
                    Thêm mới <i class="fa fa-plus"></i>
                </a>
                <div class="space10"></div>
                <section id="unseen">                    
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tên menu</th>
                            <th>Đường dẫn</th>
                            <th class="center">Hiển thị</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows))foreach($rows as $r){$i++;?> 
                        <tr id="tr_<?=$r["id"]?>">
                            <td class="center <?=($r["parent"] == 0)?"money":""?>"><?=$r["order"]?></td>
                            <td>
                                <?if($r["parent"] == 0):?>
                                <?=$r["name"]?>
                                <?else:?>
                                <div class="menu_sub">-------- <?=$r["name"]?></div>                                    
                                <?endif;?>
                            </td>
                            <td><?=$r["location"]?></td>
                            <td class="center">
                               <a href="javascript:;" onclick="return changeStatus(<?=$r["id"]?>)"> 
                                   <?if($r["status"] == 0):?>
                                   <button id="btn-color-on-switch" class="btn btn-success btn-xs">ON</button>
                                   <?else:?>
                                   <button id="btn-color-off-switch" class="btn btn-default btn-xs">OFF</button>
                                   <?endif;?> 
                               </a> 
                            </td>
                            <td class="center">
                                <a href="<?=CPANEL?>/ad_user/menu/addedit/<?=$r["id"]?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Sửa</button>
                                </a>    
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return menu_del(<?=$r["id"]?>);">
                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                            </td>
                        </tr>
                        <?}else{?>
                        <tr><td colspan="8" class="nodata">Không có dữ liệu</td></tr>  
                        <?}?>  
                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    </div>
</div>     

<?elseif($action == "addedit"):?>

<script type="text/javascript">
function menu_update(){
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
}

function validate_menu(id, o){
    var u = $(o).val();
    if(id > 0){        
        if(id == u){
            alert('Oops! 1 Menu không thể là con của chính mình');
            $("#parent option[value='0']").prop('selected', true);
            return false;
        }        
    }    
    //check sub menu 
    var prefix = $('#prefix').html();        
    $.get(prefix+'/ad_user/menu/menu_get_parent/'+u,function(rt){
        if(rt > 0){
            alert('Oops! Bạn chỉ được chọn làm Sub của menu cấp 1');
            $("#parent option[value='0']").prop('selected', true);
            return false;    
        }
    })   
    return false;
}
</script><div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?=CPANEL?>/ad_user/menu">Menu chức năng</a></li>
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
                <form class="cmxform form-horizontal bucket-form" method="post" onsubmit="return menu_update();" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên menu</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="name" id="name" value="<?=isset($row)?$row->name:""?>"/>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Đường dẫn</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="location" id="location" value="<?=isset($row)?$row->location:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thứ tự</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required txt_mini_short" name="order" id="order" value="<?=isset($row)?$row->order:0?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hiển thị</label>
                        <div class="col-sm-6">
                            <select class="form-control txt_short" id="status" name="status">
                                <option value="0" <?=(isset($row) && $row->status == 0)?"selected='selected'":""?>>Yes</option>
                                <option value="1" <?=(isset($row) && $row->status == 1)?"selected='selected'":""?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cấp cha</label>
                        <div class="col-sm-6">
                            <select id="parent" class="form-control txt_300" name="parent" onchange="return validate_menu(<?=isset($row)?$row->id:0?>,this);">
                                <option value="0">---------- Cấp mặc định ---------</option>
                                <?if(isset($menu_list))foreach($menu_list as $m){?>
                                <option value="<?=$m["id"]?>" <?=(isset($row) && $m["id"] == $row->parent)?"selected='selected'":""?>>
                                    <?if($m["parent"] > 0) echo "------".$m["name"]; else echo $m["name"];?>                                
                                </option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info">Xác nhận</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>/ad_user/menu"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
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
