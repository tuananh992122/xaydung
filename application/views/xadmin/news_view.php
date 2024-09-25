<?if(isset($action) && $action == "cat_view"):?>

<script type="text/javascript">
function delete_item(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/news/category/delete',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
        else
            console.log(rt);
    });
    return false;
}

function switch_state(id){
    var prefix = $('#prefix').html();
    $.post(prefix+'/news/category/switch_state',{id:id},function(rt){
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
            <li><a href="<?=CPANEL?>/news/manage">Tin tức</a></li>
            <li class="active">Danh mục</li>
        </ul>
        <!--breadcrumbs end -->
    </div>

    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Danh mục</header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/news/category/addedit" id="editable-sample_new" class="btn btn-xs btn-primary">
                    Thêm mới <i class="fa fa-plus"></i>
                </a>
                <div class="space10"></div>
                <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tên danh mục</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows) && count($rows) > 0) foreach($rows as $r){$i++; ?>
                        <tr>
                            <td class="center"><?=$i?></td>
                            <td>
                                <?=$r["name"]?>
                            </td>
                            <td>
                                <?if($chmod >= 777):?>
                                <a class="btn <?=($r["state"])?"btn-success":"btn-default"?> btn-xs" onclick="return switch_state(<?=$r["id"]?>);"><?=($r["state"])?"On":"Off"?></a>
                                <span class="span-space"></span>
                                <a href="<?=CPANEL?>/news/category/addedit/<?=$r["id"]?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Sửa</button>
                                </a>
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return delete_item(<?=$r["id"]?>);">
                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                                <?endif;?>
                            </td>
                        </tr>
                        <!-- Sub category -->
                        <?if(isset($r["sub"])) foreach($r["sub"] as $s):?>
                        <tr>
                            <td class="center"><?//=$s["z_index"]?></td>
                            <td class="td_sub">
                                --- <?=$s["name"]?>
                            </td>
                            <td>
                                <?if($chmod >= 777):?>
                                <a class="btn <?=($s["state"])?"btn-success":"btn-default"?> btn-xs" onclick="return switch_state(<?=$s["id"]?>);"><?=($s["state"])?"On":"Off"?></a>
                                <span class="span-space"></span>
                                <a href="<?=CPANEL?>/news/category/addedit/<?=$s["id"]?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Sửa</button>
                                </a>
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return delete_item(<?=$s["id"]?>);">
                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                                <?endif;?>
                            </td>
                        </tr>
                        <?endforeach;?>
                        
                        <?}else{?>
                        <tr><td colspan="8" class="nodata">Không có dữ liệu</td></tr>
                        <?}?>
                        <tr><td colspan="8"><div class="paged"><?=isset($pagi)?$pagi:""?></div></td></tr>
                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    </div>
</div>


<?elseif($action == "cat_addedit"):?>

<script type="text/javascript">

function form_update(){
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

</script>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/news/manage">Tin tức</a></li>
            <li><a href="<?=CPANEL?>/news/category">Danh mục</a></li>
            <li class="active">Thêm mới - Chỉnh sửa</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Thêm mới - Chỉnh sửa</header>
            <div class="panel-body">
                <?if(isset($thongbao)){?><div class="alert alert-success"><?=$thongbao?></div><?}?>
                <?if(isset($error)){?><div class="alert alert-danger"><?=$error?></div><?}?>
                <form class="cmxform form-horizontal bucket-form" method="post" onsubmit="return form_update();" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên danh mục</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required txt_300" name="name" id="name" value="<?=isset($row)?$row->name:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cấp cha</label>
                        <div class="col-sm-6">
                            <select id="parent" name="parent" class="form-control txt_200">
                                <option value="0">----- Là cấp cha</option>
                                <?if(isset($parent)) foreach($parent as $p):?>
                                <option value="<?=$p->id?>" <?=(isset($row) && $row->parent == $p->id)?"selected='selected'":""?>><?=$p->name?></option>
                                <?endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Thứ tự</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required txt_short" name="z_index" id="z_index" value="<?=isset($row)?$row->z_index:$max?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tùy chọn</label>
                        <div class="col-sm-6">
                            <label class="label_box"> <input type="checkbox" value="1" <?=(!isset($row) || $row->state == 1)?"checked='true'":""?> name="state"/> Hiển thị </label>
                            <label class="label_box"> <input type="checkbox" value="1" <?=(!isset($row) || $row->is_service == 1)?"checked='true'":""?> name="is_service"/> Dịch vụ </label>
                        </div>
                    </div>
                    <!-- SEO -->
                    <div class="seo_hr"></div>
                    <div class="seo_note">Không bắt buộc, nếu để trống hệ thống sẽ tự sinh</div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Đường dẫn</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="slug" id="slug" value="<?=isset($row)?$row->slug:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SEO title</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="seo_title" id="seo_title" value="<?=isset($row)?$row->seo_title:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SEO desc</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="seo_desc" id="seo_desc"><?=isset($row)?$row->seo_desc:""?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info">Xác nhận</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>/news/category"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
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



<?elseif($action == "view"):?>

<script type="text/javascript">
function delete_item(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/news/manage/delete',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
        else
            console.log(rt);
    });
    return false;
}

function switch_state(id){
    var prefix = $('#prefix').html();
    $.post(prefix+'/news/manage/switch_state',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
    })
}

function xfilter(){
    var prefix = $('#prefix').html();
    var title = $('#f_title').val();
    title = encodeURI(title);
    var state = $('#f_state').val();
    var cat_id = $('#f_cat_id').val();
    var hot = $('#f_hot').val();
    var location = prefix+'/news/manage/view?cat_id='+cat_id+'&state='+state+'&hot='+hot+'&title='+title;
    window.location.href = location;
    return false;
}

</script>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/news/manage">Tin tức</a></li>
            <li class="active">Bài viết</li>
        </ul>
        <!--breadcrumbs end -->
    </div>

    <div class="col-md-12">
        <div class="filter_box">
            <form id="form_filter" name="form_filter" method="post" action="" onsubmit="return xfilter();">
            <span class="filter_block">
                <span>Nhóm bài</span>
                <select id="f_cat_id" name="f_cat_id" class="form-control txt_200">
                    <option value="0"></option>
                    <?if(isset($category)) foreach($category as $c):?>
                    <option value="<?=$c["id"]?>" <?=(isset($cat_id) && $cat_id == $c["id"])?"selected='selected'":""?>><?=$c["name"]?></option>                    
                        <?if(isset($c["sub"])) foreach($c["sub"] as $s):?>
                        <option value="<?=$s["id"]?>" <?=(isset($cat_id) && $cat_id == $s["id"])?"selected='selected'":""?>>--- <?=$s["name"]?></option>                        
                        <?endforeach;?>
                    <?endforeach;?>
                </select>
            </span>
            <span class="filter_block">
                <span>Trạng thái</span>
                <select id="f_state" name="f_state" class="form-control txt_200">
                    <option value="-1"></option>
                    <option value="0" <?=(isset($state) && $state == 0)?"selected='selected'":""?>>Ẩn</option>
                    <option value="1" <?=(isset($state) && $state == 1)?"selected='selected'":""?>>Hiển thị</option>
                </select>
            </span>
            <span class="filter_block">
                <span>HOT</span>
                <select id="f_hot" name="f_hot" class="form-control txt_200">
                    <option value="-1"></option>
                    <option value="1" <?=(isset($hot) && $hot == 1)?"selected='selected'":""?>>Yes</option>
                    <option value="0" <?=(isset($hot) && $hot == 0)?"selected='selected'":""?>>No</option>
                </select>
            </span>
            <div class="space10"></div>
            <span class="filter_block">
                <span>Tiêu đề</span>
                <input type="text" class="txt_200 form-control" id="f_title" name="f_title" value="<?=isset($title)?$title:""?>"/>
            </span>
            <div class="space10"></div>
            <span class="filter_block">
                <a class="btn btn-default btn-xs" href="<?=CPANEL?>/news/manage">Reset</a>
                &nbsp;
                <a class="btn btn-info btn-xs" onclick="$('#form_filter').submit();">Lọc dữ liệu</a>
                <input type="submit" class="hidden"/>
            </span>
            </form>
        </div>
    </div>

    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Bài viết</header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/news/manage/addedit" id="editable-sample_new" class="btn btn-xs btn-primary">
                    Thêm mới <i class="fa fa-plus"></i>
                </a>
                <div class="space10"></div>
                <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tiêu đề</th>
                            <th class="center">Hình đại diện</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows)) foreach($rows as $r){$i++; ?>
                        <tr>
                            <td class="center"><?=$i?></td>
                            <td>
                                <?=$r->title?>
                                <div class="space5"></div>
                                <div class="time">Thời gian: <?=date("d-m-Y",$r->time_create)?></div>
                                <div class="hr_details"></div>
                                <a class="btn <?=($r->state)?"btn-success":"btn-default"?> btn-xs" onclick="return switch_state(<?=$r->id?>);"><?=($r->state)?"On":"Off"?></a>
                            </td>
                            <td class="center">
                                <?if($r->thumb):?>
                                <img src="<?=PREFIX?>uploads/news/thumb/<?=$r->thumb?>" width="80"/>
                                <?endif;?>
                            </td>
                            <td class="center"><?=$r->cname?></td>
                            <td>
                                <a href="<?=CPANEL?>/news/manage/addedit/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Sửa</button>
                                </a>
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return delete_item(<?=$r->id?>);">
                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                            </td>
                        </tr>
                        <?}else{?>
                        <tr><td colspan="8" class="nodata">Không có dữ liệu</td></tr>
                        <?}?>
                        <tr><td colspan="8"><div class="pagination right"><?=$pagination?></div></td></tr>
                        </tbody>
                    </table>
                </section>                
            </div>
        </section>
    </div>
</div>


<?elseif(isset($action) && $action == "addedit"):?>

<script>
function form_update(){
    var ck = 0;
    $('.alert').hide().html('');
    $('#cat_id').css('border','1px solid #ccc');
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
    var cat_id = $('#cat_id').val();
    if(cat_id == 0){
        $('#cat_id').css('border','1px solid red');
        $('.alert').show().html('Bạn cần chọn nhóm danh mục cho bài viết');
        return false;
    }
}

</script>

<style type="text/css">
#caption, #caption_en{width: 700px; height: 150px; resize: none;}
#inp_search{clear: both;margin-bottom: 20px;width: 100%;}
</style>
<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/news/manage">Tin tức</a></li>
            <li class="active">Thêm mới - Chỉnh sửa</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Thêm mới - Chỉnh sửa</header>
            <div class="panel-body">
                <?if(isset($thongbao)){?><div class="alert alert-success"><?=$thongbao?></div><?}?>
                <form class="cmxform form-horizontal bucket-form" method="post" onsubmit="return form_update();" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hình đại diện</label>
                        <div class="col-sm-6">
                             <div class="fileupload fileupload-new" data-provides="fileupload">
                                <input type="file" name="image" class="form-control txt_300"/>
                                <div class="space10"></div>
                                <span class="label label-danger">Ghi chú!</span>
                                <span>Kích thước yêu cầu: <strong>350x220</strong> px</span>
                                <div class="space10"></div>
                                <span>Chỉ hỗ trợ định dạng ảnh jpg, jpeg, png, gif</span>
                                <div class="space20"></div>
                                <span class="alert alert-danger">Dung lượng tối đa <strong>2M</strong></span>
                                <div class="space20"></div>
                            </div>
                            <?if(isset($row) && $row->thumb):?>
                            <img src="<?=PREFIX?>uploads/news/thumb/<?=$row->thumb?>" width="150"/>
                            <?endif;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Danh mục</label>
                        <div class="col-sm-6">
                             <select id="cat_id" name="cat_id" class="form-control txt_300">
                                <option value="0"></option>
                                <?if(isset($category)) foreach($category as $c):?>
                                <option value="<?=$c["id"]?>" <?=(isset($row) && $row->cat_id == $c["id"])?"selected='selected'":""?>><?=$c["name"]?></option>                    
                                    <?if(isset($c["sub"])) foreach($c["sub"] as $s):?>
                                    <option value="<?=$s["id"]?>" <?=(isset($row) && $row->cat_id == $s["id"])?"selected='selected'":""?>>--- <?=$s["name"]?></option>                        
                                    <?endforeach;?>
                                <?endforeach;?>
                             </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tùy chọn</label>
                        <div class="col-sm-6">
                            <label class="label_box"> <input type="checkbox" value="1" <?=(!isset($row) || $row->state == 1)?"checked='true'":""?> name="state"/> Hiển thị </label>
                            <div class="space5"></div>
                            <label class="label_box"> <input type="checkbox" value="1" <?=(isset($row) && $row->hot == 1)?"checked='true'":""?> name="hot"/> HOT </label>
                        </div>
                    </div>
                    <!-- Content VI -->
                    <div class="seo_hr"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tiêu đề</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="title" id="title" value="<?=isset($row)?$row->title:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Miêu tả ngắn</label>
                        <div class="col-sm-6">
                            <textarea id="caption" name="caption" class="form-control"><?=isset($row)?$row->caption:""?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nội dung</label>
                        <div class="col-sm-6">
                            <textarea id="content" name="content" class="mceEditor"><?=isset($row)?$row->content:""?></textarea>
                        </div>
                    </div>
                    <!-- SEO -->
                    <div class="seo_hr"></div>
                    <div class="seo_note">Không bắt buộc, nếu để trống hệ thống sẽ tự sinh</div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Đường dẫn</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="slug" id="slug" value="<?=isset($row)?$row->slug:""?><?=isset($send)?$send["slug"]:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SEO title</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="seo_title" id="seo_title" value="<?=isset($row)?$row->seo_title:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SEO desc</label>
                        <div class="col-sm-6">
                            <textarea class="seo_desc form-control" name="seo_desc" id="seo_desc"><?=isset($row)?$row->seo_desc:""?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info">Xác nhận</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>/news/manage"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                            <div class="space10"></div>
                            <div class="alert alert-danger hidden"></div>
                            <input type="hidden" name="id" id="id" value="<?=isset($row)?$row->id:0?>"/>
                            <input type="hidden" name="ispost" id="ispost" value="1"/>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<?include_once APPPATH."views/xadmin/tinimce_view.php";?>
<script type="text/javascript">
$(document).ready(function(){
    tinyInit(780,400);
})
</script>

<?endif;?>