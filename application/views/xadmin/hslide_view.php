<?if(isset($action) && $action == "list"):?>

<!-- Script -->
<script type="text/javascript">
function hslide_del(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/setting/hslide/delete',{id:id},function(rt){
        console.log(rt);
        if(rt == 'success')
            $('#tr_'+id).remove();
    });
    return false;
}

function changeis_active(id,type){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/setting/hslide/is_active',{id:id},function(rt){
        console.log(rt);
        if(rt == 'success')
            window.location.reload();
    })
}

</script>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="#">Slide trang chủ </a></li>
            <li class="active">Hình ảnh</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Hình ảnh
            </header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/setting/hslide/addedit" id="editable-sample_new" class="btn btn-primary">
                    Thêm mới <i class="fa fa-plus"></i>
                </a>
                <div class="space10"></div>
                <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tiêu đề</th>
                            <th>Ảnh hiển thị</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows))foreach($rows as $r){$i++;?>
                        <tr id="tr_<?=$r->id;?>">
                            <td class="center"><?=$i?>
                                <div class="hr_details"></div>
                                <?=$r->z_index;?>
                            </td>
                            <td>
                                <?=$r->title?>
                                <div class="hr_details"></div>
                                <?=$r->link?>
                            </td>
                            <td>
                                <img src="<?=base_url()."uploads/hslide/thumb/".$r->image?>" width="100px" />

                            </td>
                            <td class="center">
                               <a href="javascript:;" onclick="return changeis_active(<?=$r->id;?>,'is_active')">
                                   <?if($r->is_active == 1):?>
                                   <button id="btn-color-on-switch" class="btn btn-success btn-xs">ON</button>
                                   <?else:?>
                                   <button id="btn-color-off-switch" class="btn btn-danger btn-xs">OFF</button>
                                   <?endif;?>
                               </a>
                            </td>
                            <td class="center">
                                <a href="<?=CPANEL?>/setting/hslide/addedit/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-sm"><i class="fa fa-cog"></i> Sửa</button>
                                </a>
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return hslide_del(<?=$r->id?>);">
                                    <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                            </td>
                        </tr>
                        <?}else{?>
                        <tr><td colspan="8" class="nodata">Không có dữ liệu</td></tr>
                        <?}?>
                        </tbody>
                    </table>
                </section>
                <?php echo $pagi; ?>
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

</script><div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?=CPANEL?>/setting/hslide">Slide trang chủ</a></li>
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
                <?if(isset($error)){?><div class="alert alert-warning"><?=$error?></div><?}?>
                <form class="cmxform form-horizontal bucket-form" method="post" onsubmit="return menu_update();" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tiêu đề</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="title" id="title" value="<?=isset($row)?$row->title:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Link chi tiết</label>
                        <div class="col-sm-6">
                            <input class="form-control required" name="link" id="link" value="<?=isset($row)?$row->link:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Link Demo</label>
                        <div class="col-sm-6">
                            <input class="form-control required" name="link_demo" id="link_demo" value="<?=isset($row)?$row->link_demo:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Mô tả</label>
                        <div class="col-sm-6">
                            <textarea name="caption" class="form-control"><?=isset($row)?$row->caption:""?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ảnh hiển thị</label>
                        <div class="col-sm-6">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <input type="file" class="form-control txt_300" name="image" id="image" value=""/>
                                <div class="space10"></div>
                                <span class="label label-danger">Ghi chú!</span>
                                <span>Kích thước yêu cầu tối thiểu: <strong>1342 x 493</strong> px</span>
                                <div class="space10"></div>
                                <span>Chỉ hỗ trợ định dạng ảnh jpg, jpeg, png, gif</span>
                                <div class="space20"></div>
                                <span class="alert alert-danger">Server / Hosting cho phép file dung lượng tối đa <strong><?=ini_get('upload_max_filesize')?></strong></span>
                                <div class="space20"></div>
                            </div>
                            <input type="hidden" name="old-image" id="old-image" value="<?=isset($row)?$row->image:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hiển thị</label>
                        <div class="col-sm-6">
                            <select class="form-control txt_short" id="is_active" name="is_active">
                                <option value="1" <?=(isset($row) && $row->is_active == 1)?"selected='selected'":""?>>Yes</option>
                                <option value="0" <?=(isset($row) && $row->is_active == 0)?"selected='selected'":""?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thứ tự</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control txt_short" name="z_index" id="z_index" value="<?=isset($row)?$row->z_index:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info">Xác nhận</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>/setting/hslide"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
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
