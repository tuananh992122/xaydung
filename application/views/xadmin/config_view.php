<?if(isset($action) && $action == "view"):?>
<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li class="active">Cấu hình chung</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cấu hình chung
            </header>
            <div class="panel-body">
                <div class="space10"></div>
                <section id="unseen">                    
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tên</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows))foreach($rows as $r){$i++;?> 
                        <tr>
                            <td class="center"><?=$i?></td>
                            <td><?=$r->name?></td>
                            <td>
                                <a href="<?=CPANEL?>/setting/config/addedit/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog"></i> Sửa</button>
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


<?elseif(isset($action) && $action == "addedit"):?>

<?if(isset($row) && $row->kind == 1):?>
    <?include_once APPPATH."views/xadmin/tinimce_view.php";?>
    <script type="text/javascript">
    $(document).ready(function(){
        tinyInit(780,400);
    })
    </script>
<?endif;?>

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
<style type="text/css">
textarea#content{height: 170px;resize: none;}
</style>
<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="<?=CPANEL?>/setting/config">Cấu hình</a></li>
            <li class="active">Chỉnh sửa</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading"> Chỉnh sửa </header>
            <div class="panel-body">
                <form enctype="multipart/form-data" class="cmxform form-horizontal bucket-form" action="" onsubmit="return form_update();" name="form_submit" id="form_submit" method="post">                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control txt_200" disabled="true" value="<?=isset($row)?$row->name:""?>"/>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Giá trị</label>
                        <div class="col-sm-6">
                            <?if($row->kind == 0):?>
                            <input type="text" class="form-control required" name="content" id="content" value="<?=isset($row)?$row->content:""?>"/>
                            <?else:?>
                            <textarea id="content" name="content" class="mceEditor form-control"><?=isset($row)?$row->content:""?></textarea>
                            <?endif;?>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-info">Xác nhận</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>/setting/config"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                            <div class="space10"></div>
                            <div class="alert alert-danger hidden left"></div>
                            <input type="hidden" name="id" id="id" value="<?=isset($row)?$row->id:-1?>"/>
                        </div>
                    </div> 
                  </form>
            </div>
        </section>
    </div>
</div>
<?endif;?>