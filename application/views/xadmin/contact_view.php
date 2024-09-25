<?if(isset($action) && $action == "view"):?>

<script type="text/javascript">
function delete_item(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/setting/contact/delete',{id:id},function(rt){
        if(rt == 'success')
            window.location.reload();
        else 
            console.log(rt);          
    });    
    return false;
}

function xfilter(){
    var prefix = $('#prefix').html();
    var read = $('#f_read').val();         
    var location = prefix+'/setting/contact/view/read='+read;    
    window.location.href = location;
    return false;
}

</script>
<style type="text/css">
.unread{font-weight: bold;color: #086286;}
</style>
<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li class="active">Liên hệ</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-md-12">
        <div class="filter_box">
            <form id="form_filter" name="form_filter" method="post" action="" onsubmit="return xfilter();">           
            <span class="filter_block">
                <span>Trạng thái</span>
                <select id="f_read" name="f_read" class="form-control txt_200">
                    <option value="-1"></option>
                    <option value="0" <?=(isset($f_read) && $f_read == 0)?"selected='selected'":""?>>Chưa đọc</option>
                    <option value="1" <?=(isset($f_read) && $f_read == 1)?"selected='selected'":""?>>Đã đọc</option>
                </select>
            </span>
            <span class="filter_block">
                <a class="btn btn-default btn-sm" href="<?=CPANEL?>/setting/contact">Reset</a>
                &nbsp;               
                <a class="btn btn-info btn-sm" onclick="$('#form_filter').submit();">Lọc dữ liệu</a>
                <input type="submit" class="hidden"/>
            </span>
            </form>
        </div>
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Liên hệ</header>
            <div class="panel-body">
                <section id="unseen">                    
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Người gửi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=$offset; if(isset($rows)) foreach($rows as $r){$i++; ?> 
                        <tr>
                            <td class="center <?=($r->is_read == 0)?"unread":""?>">
                                <?=$i?>
                                <div class="hr_details"></div>
                                <?=date("d-m-Y H:i",$r->time)?>
                            </td>
                            <td class="middle">
                                <?=$r->name?>
                                <div class="hr_details"></div>
                                <?=$r->email." / ".$r->phone?>
                            </td>
                            <td>
                                <?if($chmod >= 444):?>
                                <a href="<?=CPANEL?>/setting/contact/details/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Chi tiết</button>
                                </a>    
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return delete_item(<?=$r->id?>);">
                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Xóa</button>
                                </a>
                                <?endif;?>
                            </td>
                        </tr>
                        <tr><td colspan="10"></td></tr>
                        <?}else{?>
                        <tr><td colspan="8" class="nodata">Không có dữ liệu</td></tr>  
                        <?}?>  
                        <tr><td colspan="8"><div class="paged right"><?=isset($pagi)?$pagi:""?></div></td></tr>
                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    </div>
</div>


<?elseif($action == "details"):?>

<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/setting/contact">Liên hệ</a></li>
            <li class="active">Chi tiết</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Liên hệ</header>
            <div class="panel-body">
                <section id="unseen">                    
                    <table class="table table-bordered table-striped table-condensed">                        
                        <tbody>                         
                        <tr>
                            <td>Thời gian</td>
                            <td><?=date("d-m-Y H:i",$row->time)?></td>
                        </tr>
                        <tr>
                            <td>Người gửi</td>
                            <td>
                                <?=$row->name?>
                                <div class="hr_details"></div>
                                <?=$row->email?>
                                <div class="hr_details"></div>
                                <?=$row->phone?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nội dung</td>
                            <td><?=$row->content?></td>
                        </tr>
                        <tr><td colspan="2"><a class="btn btn-default" href="<?=CPANEL?>/setting/contact"><i class="fa fa-long-arrow-left"></i> Quay lại</a></td></tr>
                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    </div>
</div>


<?endif;?>