<?if(isset($action) && $action == "list"):?>

<!-- Script -->
<script type="text/javascript">
function video_del(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/setting/video/delete',{id:id},function(rt){
        if(rt == 'success')
            $('#tr_'+id).remove();             
    });    
    return false;
}

function changeis_active(id,type){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/setting/video/is_active',{id:id},function(rt){
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
            <li><a href="#">Quản lý chung</a></li>
            <li class="active">Video</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Video
            </header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/setting/video/addedit" id="editable-sample_new" class="btn btn-primary">
                    Thêm mới <i class="fa fa-plus"></i>
                </a>
                <div class="space10"></div>
                <section id="unseen">                    
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tiêu đề</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows))foreach($rows as $r){$i++;?> 
                        <tr id="tr_<?=$r->id;?>">
                            <td class="center"><?=$i?>
                            <div class="hr_details"></div>
                            <?=date("d-m-Y",$r->time_created)?>
                            </td>
                            <td><?=$r->title?>
                            <div class="hr_details"></div>
                            <?=$r->url?>
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
                                <a href="<?=CPANEL?>/setting/video/addedit/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-sm"><i class="fa fa-cog"></i> Sửa</button>
                                </a>    
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return video_del(<?=$r->id?>);">
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
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/video/video">Quản lý video</a></li>
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
                        <label class="col-sm-3 control-label">Tiêu đề</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="title" id="title" value="<?=isset($row)?$row->title:""?>"/>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Đường dẫn</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="url" id="url" value="<?=isset($row)?$row->url:""?>"/>
                                                 
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
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info">Xác nhận</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>/setting/video"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
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
