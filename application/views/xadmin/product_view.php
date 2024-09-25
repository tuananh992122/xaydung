<?if(isset($action) && $action == "cat_view"):?>

<script type="text/javascript">
function delete_item(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/product/category/delete',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
        else
            console.log(rt);
    });
    return false;
}

function switch_state(id){
    var prefix = $('#prefix').html();
    $.post(prefix+'/product/category/switch_state',{id:id},function(rt){
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
            <li><a href="<?=CPANEL?>/product/manage">Sản phẩm</a></li>
            <li class="active">Danh mục</li>
        </ul>
        <!--breadcrumbs end -->
    </div>

    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Danh mục</header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/product/category/addedit" id="editable-sample_new" class="btn btn-xs btn-primary">
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
                                <a class="btn <?=($r["is_active"])?"btn-success":"btn-default"?> btn-xs" onclick="return switch_state(<?=$r["id"]?>);"><?=($r["is_active"])?"On":"Off"?></a>
                                <span class="span-space"></span>
                                <a href="<?=CPANEL?>/product/category/addedit/<?=$r["id"]?>">
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
                                <a class="btn <?=($s["is_active"])?"btn-success":"btn-default"?> btn-xs" onclick="return switch_state(<?=$s["id"]?>);"><?=($s["is_active"])?"On":"Off"?></a>
                                <span class="span-space"></span>
                                <a href="<?=CPANEL?>/product/category/addedit/<?=$s["id"]?>">
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
            <li><a href="<?=CPANEL?>/product/manage">Sản phẩm</a></li>
            <li><a href="<?=CPANEL?>/product/category">Danh mục</a></li>
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
                            <label class="label_box"> <input type="checkbox" value="1" <?=(!isset($row) || $row->is_active == 1)?"checked='true'":""?> name="is_active"/> Hiển thị </label>
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
                            <a class="btn btn-default" href="<?=CPANEL?>/product/category"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
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
    $.post('<?=CPANEL?>/product/manage/delete',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
        else
            console.log(rt);
    });
    return false;
}

function switch_state(id){
    var prefix = $('#prefix').html();
    $.post(prefix+'/product/manage/switch_state',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
    })
}

function xfilter(){
    var prefix = $('#prefix').html();
    var name = $('#f_title').val();
    name = encodeURI(name);
    var is_active = $('#f_state').val();
    var product_cat = $('#f_cat_id').val();
    var hot = $('#f_hot').val();
    var location = prefix+'/product/manage/view?product_cat='+product_cat+'&is_active='+is_active+'&hot='+hot+'&name='+name;
    window.location.href = location;
    return false;
}

</script>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/product/manage">Quản lý Sản phẩm</a></li>
            <li class="active">Sản phẩm</li>
        </ul>
        <!--breadcrumbs end -->
    </div>

    <div class="col-md-12">
        <div class="filter_box">
            <form id="form_filter" name="form_filter" method="post" action="" onsubmit="return xfilter();">
            <span class="filter_block">
                <span>Danh mục</span>
                <select id="f_cat_id" name="f_cat_id" class="form-control txt_200">
                    <option value="0"></option>
                    <?if(isset($category)) foreach($category as $c):?>
                    <option value="<?=$c["id"]?>" <?=(isset($product_cat) && $product_cat == $c["id"])?"selected='selected'":""?>><?=$c["name"]?></option>                    
                        <?if(isset($c["sub"])) foreach($c["sub"] as $s):?>
                        <option value="<?=$s["id"]?>" <?=(isset($product_cat) && $product_cat == $s["id"])?"selected='selected'":""?>>--- <?=$s["name"]?></option>                        
                        <?endforeach;?>
                    <?endforeach;?>
                </select>
            </span>
            <span class="filter_block">
                <span>Trạng thái</span>
                <select id="f_state" name="f_state" class="form-control txt_200">
                    <option value="-1"></option>
                    <option value="0" <?=(isset($is_active) && $is_active == 0)?"selected='selected'":""?>>Ẩn</option>
                    <option value="1" <?=(isset($is_active) && $is_active == 1)?"selected='selected'":""?>>Hiển thị</option>
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
                <input type="text" class="txt_200 form-control" id="f_title" name="f_title" value="<?=isset($name)?$name:""?>"/>
            </span>
            <div class="space10"></div>
            <span class="filter_block">
                <a class="btn btn-default btn-xs" href="<?=CPANEL?>/product/manage">Reset</a>
                &nbsp;
                <a class="btn btn-info btn-xs" onclick="$('#form_filter').submit();">Lọc dữ liệu</a>
                <input type="submit" class="hidden"/>
            </span>
            </form>
        </div>
    </div>

    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Sản phẩm</header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/product/manage/addedit" id="editable-sample_new" class="btn btn-xs btn-primary">
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
                                <?=$r->name?>
                                <div class="space5"></div>
                                <div class="time">Thời gian: <?=date("d-m-Y",$r->time_create)?></div>
                                <div class="hr_details"></div>
                                <a class="btn <?=($r->is_active)?"btn-success":"btn-default"?> btn-xs" onclick="return switch_state(<?=$r->id?>);"><?=($r->is_active)?"On":"Off"?></a>
                            </td>
                            <td class="center">
                                <?if($r->thumb):?>
                                <img src="<?=PREFIX?>uploads/product/thumb/<?=$r->thumb?>" width="80"/>
                                <?endif;?>
                            </td>
                            <td class="center"><?=$r->cname?></td>
                            <td>
                                <a href="<?=CPANEL?>/product/manage/addedit/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Sửa</button>
                                </a>
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return delete_item(<?=$r->id?>);">
                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                                <span class="span-space"></span>
                                <a href="<?=CPANEL?>/product/gallery/view/<?=$r->id?>">
                                    <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-picture-o" aria-hidden="true"></i> Gallery</button>
                                </a>
                                <span class="span-space"></span>
                                <a href="<?=CPANEL?>/product/product_sold/view/<?=$r->id?>">
                                    <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-users" aria-hidden="true"></i> Khách hàng</button>
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
<script type="text/javascript" src="<?=PREFIX?>js/jquery.formatCurrency-1.4.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.amount').formatCurrency({roundToDecimalPlace: 0,symbol:'',digitGroupSymbol:','});
    $(".amount").keyup(function(){
        $('.amount').formatCurrency({roundToDecimalPlace: 0,symbol:''});
    })   
})
function form_update(){
    var ck = 0;
    $('.alert').hide().html('');
    $('#product_cat').css('border','1px solid #ccc');
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
    var product_cat = $('#product_cat').val();
    if(product_cat == 0){
        $('#product_cat').css('border','1px solid red');
        $('.alert').show().html('Bạn cần chọn nhóm danh mục cho bài viết');
        return false;
    }
}
$(document).ready(function(){
    if($("#is_slide").is(':checked')){
        $('.slide_upload').css('opacity',1);
    }
    else
        $('.slide_upload').css('opacity',0.4);
        
    $("#is_slide").click(function(){
        if($(this).is(':checked')){
            $('.slide_upload').css('opacity',1);
        }
        else
            $('.slide_upload').css('opacity',0.4);
    });
})


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
            <li><a href="<?=CPANEL?>/product/manage">Tin tức</a></li>
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
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-4">
                            <label class="control-label">Hình đại diện</label>
                            <div class="space10"></div>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <input type="file" name="image" class="form-control txt_300"/>
                                <div class="space10"></div>
                                <span class="label label-danger">Ghi chú!</span>
                                <span>Kích thước yêu cầu: <strong>750x465</strong> px</span>
                                <div class="space10"></div>
                                <span>Chỉ hỗ trợ định dạng ảnh jpg, jpeg, png, gif</span>
                                <div class="space20"></div>
                                <span class="alert alert-danger">Dung lượng tối đa <strong>2M</strong></span>
                                <div class="space20"></div>
                            </div>
                            <?if(isset($row) && $row->thumb):?>
                            <img src="<?=PREFIX?>uploads/product/thumb/<?=$row->thumb?>" width="200"/>
                            <?endif;?>
                        </div>
                        <div class="col-sm-4 slide_upload">
                            <label class="control-label">Slide</label>
                            <div class="space10"></div>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <input type="file" name="slide" class="form-control txt_300"/>
                                <div class="space10"></div>
                                <span class="label label-danger">Ghi chú!</span>
                                <span>Kích thước yêu cầu: <strong>660x386</strong> px</span>
                                <div class="space10"></div>
                                <span>Chỉ hỗ trợ định dạng ảnh jpg, jpeg, png, gif</span>
                                <div class="space20"></div>
                                <span class="alert alert-danger">Dung lượng tối đa <strong>2M</strong></span>
                                <div class="space20"></div>
                            </div>
                            <?if(isset($row) && $row->slide):?>
                            <img src="<?=PREFIX?>uploads/product/slide/thumb/<?=$row->slide?>" width="200"/>
                            <?endif;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Danh mục</label>
                        <div class="col-sm-6">
                             <select id="product_cat" name="product_cat" class="form-control txt_300">
                                <option value="0"></option>
                                <?if(isset($category)) foreach($category as $c):?>
                                <option value="<?=$c["id"]?>" <?=(isset($row) && $row->product_cat == $c["id"])?"selected='selected'":""?>><?=$c["name"]?></option>                    
                                    <?if(isset($c["sub"])) foreach($c["sub"] as $s):?>
                                    <option value="<?=$s["id"]?>" <?=(isset($row) && $row->product_cat == $s["id"])?"selected='selected'":""?>>--- <?=$s["name"]?></option>                        
                                    <?endforeach;?>
                                <?endforeach;?>
                             </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tùy chọn</label>
                        <div class="col-sm-6">
                            <label class="label_box"> <input type="checkbox" value="1" <?=(!isset($row) || $row->is_active == 1)?"checked='true'":""?> name="is_active"/> Hiển thị </label>
                            <div class="space5"></div>
                            <label class="label_box"> <input type="checkbox" value="1" <?=(isset($row) && $row->hot == 1)?"checked='true'":""?> name="hot"/> HOT </label>
                            <div class="space5"></div>
                            <label class="label_box"> <input type="checkbox" value="1" <?=(isset($row) && $row->is_slide == 1)?"checked='true'":""?> id="is_slide" name="is_slide"/> Sử dụng làm Slide </label>
                        </div>
                    </div>
                    <!-- Content VI -->
                    <div class="seo_hr"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên sản phẩm</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="name" id="name" value="<?=isset($row)?$row->name:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Giá sản phẩm (VNĐ)</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control amount required txt_200" name="price" id="price" value="<?=isset($row)?$row->price:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Link Demo Front-end</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="link_home" id="link_home" value="<?=isset($row)?$row->link_home:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Link Demo Back-end</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="link_admin" id="link_admin" value="<?=isset($row)?$row->link_admin:""?>"/>
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
                            <a class="btn btn-default" href="<?=CPANEL?>/product/manage"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
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
<?elseif($action == "gallery_view"):?>

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

function img_delete(g_id){
    if(!confirm('Bạn chắc chắn muốn xóa?'))
        return false;
    var prefix = $('#prefix').html();
    $.post(prefix+'/product/gallery/delete',{id:g_id},function(rt){
        if(rt == 'success')
            window.location.reload();
        else
            console.log(rt);            
    })
    return false;            
}

</script>
<style type="text/css">
.imgs{float: left; margin: 10px; min-height: 224px;}
.imgs img{border: 1px solid #ddd;}
.span_del{display: block;float: right;margin-left: -15px;z-index: 1000;position: relative;
    margin-top: -13px;font-size: 30px; cursor: pointer;}
.private{color: #a94442;}
</style>
<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/product/manage">Sản phẩm</a></li>
            <li class="active">Hình ảnh</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Hình ảnh</header>
            <div class="panel-body">
                <?if(isset($gallery)) foreach($gallery as $g):?>
                <div class="imgs">                    
                    <img src="<?=PREFIX?>uploads/product/gallery/<?=$g->product_id?>/thumb/<?=$g->image?>" width="150"/>
                    <span class="fa fa-times-circle span_del" onclick="return img_delete(<?=$g->id?>);" title="Xóa hình ảnh"></span>                                        
                </div>
                
                <?endforeach;?>
            </div>
        </section>
    
        <section class="panel">
            <header class="panel-heading">Upload Hình ảnh</header>
            <div class="panel-body">
                <?if(isset($thongbao)){?><div class="alert alert-success"><?=$thongbao?></div><?}?>
                <form class="cmxform form-horizontal bucket-form" method="post" onsubmit="return form_update();" enctype="multipart/form-data">                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Lựa chọn ảnh</label>
                        <div class="col-sm-6">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <input type="file" name="image" class="form-control txt_300"/>                                
                                <div class="space10"></div>
                                <span class="label label-danger">Ghi chú!</span>
                                <span>Kích thước yêu cầu: <strong>135x140</strong> px</span>
                                <div class="space10"></div>
                                <span>Chỉ hỗ trợ định dạng ảnh jpg, jpeg, png, gif</span>
                                <div class="space20"></div>
                                <span class="alert alert-danger">Server / Hosting cho phép file dung lượng tối đa <strong><?=ini_get('upload_max_filesize')?></strong></span>
                                <div class="space20"></div>
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info">Upload ảnh</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>/product/manage"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                            <div class="space10"></div>
                            <div class="alert alert-danger hidden"></div>
                            <input type="hidden" name="ispost" id="ispost" value="1"/>
                        </div>
                    </div>            
                </form>
            </div>
        </section>
    </div>
</div>
<?elseif($action == "sold_view"):?>

<script type="text/javascript">
function delete_item(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/product/product_sold/delete/<?=$product_id?>',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
        else
            console.log(rt);
    });
    return false;
}

</script>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/product/manage">Sản phẩm</a></li>
            <li class="active">Khách hàng đã sử dụng sản phẩm</li>
        </ul>
        <!--breadcrumbs end -->
    </div>

    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Khách hàng</header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/product/product_sold/addedit/<?=$product_id?>" id="editable-sample_new" class="btn btn-xs btn-primary">
                    Thêm mới <i class="fa fa-plus"></i>
                </a>
                <div class="space10"></div>
                <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tên trang web</th>
                            <th class="center">Hình đại diện</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows)) foreach($rows as $r){$i++; ?>
                        <tr>
                            <td class="center"><?=$r->id?></td>
                            <td>
                                <?=$r->name?>
                            </td>
                            <td class="center">
                                <?if($r->thumb):?>
                                <img src="<?=PREFIX?>uploads/product/sold/<?=$r->thumb?>" width="100"/>
                                <?endif;?>
                            </td>
                            <td>
                                <a href="<?=CPANEL?>/product/product_sold/addedit/<?=$product_id?>/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Sửa</button>
                                </a>
                                <span class="span-space"></span>
                                <a href="javascript:void(0);" onclick="return delete_item(<?=$r->id?>);">
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


<?elseif(isset($action) && $action == "sold_addedit"):?>

<script>
function form_update(){
    var ck = 0;
    $('.alert').hide().html('');
    $('#product_cat').css('border','1px solid #ccc');
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
    var product_cat = $('#product_cat').val();
    if(product_cat == 0){
        $('#product_cat').css('border','1px solid red');
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
            <li><a href="<?=CPANEL?>/product/manage">Tin tức</a></li>
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
                                <span>Kích thước yêu cầu: <strong>100x100</strong> px</span>
                                <div class="space10"></div>
                                <span>Chỉ hỗ trợ định dạng ảnh jpg, jpeg, png, gif</span>
                                <div class="space20"></div>
                                <span class="alert alert-danger">Dung lượng tối đa <strong>2M</strong></span>
                                <div class="space20"></div>
                            </div>
                            <?if(isset($row) && $row->thumb):?>
                            <img src="<?=PREFIX?>uploads/product/sold/<?=$row->thumb?>" width="150"/>
                            <?endif;?>
                        </div>
                    </div>
                    <!-- Content VI -->
                    <div class="seo_hr"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên đơn vị</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="name" id="name" value="<?=isset($row)?$row->name:""?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Link website</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control required" name="link" id="link" value="<?=isset($row)?$row->link:""?>"/>
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
                            <a class="btn btn-default" href="<?=CPANEL?>/product/product_sold/view/<?=$product_id?>"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
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

<?elseif($action == "order_view"):?>

<script type="text/javascript">
function delete_item(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/product/order/delete',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
        else 
            console.log(rt);          
    });    
    return false;
}

</script>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li class="active">Quản lý đơn hàng</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Quản lý đơn hàng</header>
            <div class="panel-body">
                <div class="space10"></div>
                <section id="unseen">                    
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tên</th>
                            <th>Số điện thoại</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows) && count($rows) > 0) foreach($rows as $r){$i++; ?> 
                        <tr style="<?=($r->is_read==0)?'font-weight:bold;font-style: italic;':''?>">
                            <td class="center"><?=$i?></td>
                            <td>
                                <?=$r->name?>
                                <div class="hr_details"></div>
                                <?=$r->address?>
                            </td>
                            <td><?=$r->phone?></td>
                            <td>
                                <?if($chmod >= 777):?>
                                <a href="<?=CPANEL?>/product/order/detail/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Chi tiết</button>
                                </a>  
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return delete_item(<?=$r->id?>);">
                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                                <?endif;?>
                            </td>
                        </tr>
                        <?}else{?>
                        <tr><td colspan="8" class="nodata">Không có dữ liệu</td></tr>  
                        <?}?>  
                        <tr><td colspan="8"><div class="pagination right"><ul><?=isset($pagi)?$pagi:""?></ul></div></td></tr>
                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    </div>
</div>


<?elseif($action == "order_detail"):?>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/order/manage">Đơn hàng</a></li>
            <li class="active">Chi tiết</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Chi tiết</header>
            <?if(isset($row)):?>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                    <tr>
                        <td>Mã đơn hàng</td>
                        <td>
                            <?=$row->id?>
                            <div class="hr_details"></div>
                            <?=date('d-m-Y H:i',$row->time)?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tên khách hàng</td>
                        <td>
                            <?=$row->name?>
                            <div class="hr_details"></div>
                            <?=$row->phone?>
                            <div class="hr_details"></div>
                            <?=$row->email?>
                        </td>
                    </tr>
                    <tr>
                        <td>Ðịa chỉ</td>
                        <td><?=$row->address?></td>
                    </tr>
                    <tr>
                        <td>Sản phẩm</td>
                        <td>
                            <?if(isset($product)):?>
                            <p><?=$product->name?></p>
                            <div class="hr_details"></div>
                            <p>Giá bán: <?=$product->price?>$ </p>
                            <img width="300" src="<?=PREFIX."uploads/product/".$product->thumb?>"/>
                            <?else: echo $row->product_name;endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a class="btn btn-default" href="<?=CPANEL?>/product/order"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                        </td>
                    </tr>
                    </tbody>
                </table> 
            </div>
            <?else:
            echo "<p style='padding:10px'>Sản phẩm không tồn tại</p>";
            endif;
            ?>
        </section>
    </div>
</div>

<?endif;?>