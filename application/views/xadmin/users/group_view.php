<?if(isset($action) && $action == "list"):?>

<!-- Script -->
<script type="text/javascript">
function group_del(id){
    if(!confirm('Are you sure?'))
        return false;
    $.post('<?=CPANEL?>/ad_user/group/delete',{id:id},function(rt){
        if(rt == 'success')
            $('#tr_'+id).remove();            
    });    
    return false;
}
</script>
<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i></a></li>
            <li><a href="#">Thành viên quản trị</a></li>
            <li class="active">Nhóm thành viên</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Nhóm thành viên
            </header>
            <div class="panel-body">
                <a href="<?=CPANEL?>/ad_user/group/addedit" id="editable-sample_new" class="btn btn-primary btn-xs">
                    Thêm mới <i class="fa fa-plus"></i>
                </a>
                <div class="space10"></div>
                <section id="unseen">                    
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th class="center">STT</th>
                            <th>Tên nhóm</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?$i=0; if(isset($rows))foreach($rows as $r){$i++; if($r->id == 0) continue;?> 
                        <tr id="tr_<?=$r->id?>">
                            <td class="center"><?=$i?></td>
                            <td><?=$r->name?></td>
                            <td>
                                <a href="<?=CPANEL?>/ad_user/group/addedit/<?=$r->id?>">
                                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog btn-xs"></i> Sửa</button>
                                </a>    
                                <span class="span-space"></span>
                                <a href="javascript:;" onclick="return group_del(<?=$r->id?>);">
                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times btn-xs"></i> Xóa</button>
                                </a>
                            </td>
                        </tr>
                        
                        <?$sub_group = $this->user->group_get($r->id);
                        if($sub_group && $r->id != 0) foreach($sub_group as $s){?>
                        <tr id="tr_<?=$s->id?>">
                          <td></td>                
                          <td class="p_name">--------- <?=$s->name?></td>
                          <td>
                              <?if($s->id > 0):?>
                              <a href="<?=CPANEL?>/ad_user/group/addedit/<?=$s->id?>">
                                <button type="button" class="btn btn-info btn-xs"><i class="fa fa-cog btn-xs"></i> Sửa</button>
                              </a>
                              <span class="span-space"></span>
                              <a href="javascript:;" onclick="return group_del(<?=$s->id?>);">
                                <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times btn-xs"></i> Xóa</button>
                              </a>             
                              <?endif;?> 
                          </td>
                        </tr>  
                        <?}?>
                        
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
function group_update(){ 
    $('.alert').hide().html('');
    submit_checkbox();
    var name = $('#name').val();
    if(name == ''){
        $('.alert').show().html('Tên nhóm không được rỗng.');
        return false;
    }
}

function submit_checkbox(){
    var ids = "";
    $('[class^="tr_group_"]').each(function(){
        if($(this).find('[class^="ckb_"]').is(':checked')){            
            ids += $(this).find('[class^="ckb_"]:checked').val() + ',';
        }                
    })
    $('#role_ids').val(ids);
}

//Uncheck | check all role
function changeAll(chmod){
    $('[class^="tr_group_"]').find('.ckb_'+chmod).prop('checked',true);
    return false;
}

//Once checkbox change
//parent id, ident, chmod, this
function checkbox_change(parent_id, ident, chmod, o){
    var prefix = $('#prefix').html();
    if(parent_id == 0){
        if($(o).is(':checked')){
            $('.tr_group_'+ident).find('input[type="radio"]').removeAttr('checked');
            $('.tr_group_'+ident).find('.ckb_'+chmod).prop('checked',true);
        }
    }
    var cktrue = 0;
    var max = $('.tr_group_'+ident).find('.ckb_'+chmod).length;
    $('.tr_group_'+ident).find('.ckb_'+chmod).each(function(){
        if($(this).is(':checked'))
            cktrue++;
    })
    if(cktrue < max){
        $('.tr_bg_head').find('input[type="radio"]').removeAttr('checked');
    }
    return false;
}
function remove_radio_selected(ident, o){      
    $(o).parents('.tr_group_'+ident).find('[name^="ckbox_"]').removeAttr('checked');
    return false;
}
$(document).ready(function(){
    $('[class^="tr_group_"]').hover(function(){
        $(this).find('.img_radio_remove').show();
    },function(){
        $(this).find('.img_radio_remove').hide();
    })
})
</script>
<style type="text/css">
.well{width: 1000px; float: left;}
.r_title{font-weight: bold;font-size: 13px;}
#left_cols{float: left; width: 375px;}
#right_cols{float: left; margin-left: 20px; width: 636px;min-height: 300px;}
#tbl_cat{margin: 0 auto;width: 525px; margin-left: 44px;}
#tbl_cat td{border: 1px solid #dedede;height: 30px;padding: 0 20px;}
.tbl_head td{background: #EC9754;color: #FFF;}
.label_inline{float: left; display: inline-block;margin-right: 16px; border-right: 1px dotted #B3B3B3; padding-right: 10px; margin-top: 5px;font-size: 12px;}
.label_inline input{vertical-align: middle;margin-top: -4px; margin-left: 4px;}
.label_inline_last{margin-right: 0; border-right: none;}
.tr_bg_head{background: #d3d3d3;}
.img_radio_remove{float: left; margin-top: 6px; cursor: pointer;}
</style>
<div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="<?=CPANEL?>"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?=CPANEL?>/ad_user/group">Nhóm thành viên</a></li>
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
                <form enctype="multipart/form-data" class="cmxform form-horizontal bucket-form" action="" onsubmit="return group_update();" name="form_submit" id="form_submit" method="post">  
                  <div id="left_cols">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tên nhóm</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control txt_200 required" name="name" id="name" value="<?=isset($row)?$row->name:""?>"/>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Cấp cha</label>
                        <div class="col-sm-6">
                            <select id="parent" name="parent" class="form-control txt_200">
                                <option value="0"></option>                                
                                <?if(isset($group_all)) foreach($group_all as $ga){ if($ga->id > 0){?>
                                <option value="<?=$ga->id?>" <?=(isset($row) && $ga->id == $row->parent)?"selected='selected'":""?>>-------- <?=$ga->name?></option>
                                <?}}?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-info">Xác nhận</button>
                            <span class="span-space"></span>
                            <a class="btn btn-default" href="<?=CPANEL?>/ad_user/group"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                            <div class="space10"></div>
                            <div class="alert alert-danger hidden"></div>
                            <input type="hidden" name="id" id="id" value="<?=isset($row)?$row->id:-1?>"/>
                        </div>
                    </div>                                                   
                  </div> 
                  <!-- Right column -->
                  <div id="right_cols">                              
                       <div class="r_title center">Phân quyền truy cập</div>
                       <div class="space5"></div>
                       <table id="tbl_cat">
                            <tr class="tbl_head">
                                <td>Chức năng</td>
                                <td>                            
                                    <label class="label_inline">Read
                                    <input type="radio" name="ckbox_all" onchange="return changeAll(444)"/>
                                    </label>
                                    <label class="label_inline label_inline_last">Write    
                                    <input type="radio" name="ckbox_all" onchange="return changeAll(777)"/>
                                    </label> 
                                </td>
                            </tr>
                            <?$i=0; if(isset($menu))foreach($menu as $m){ if($m["parent"] == 0) $i++;?>
                            <tr class="<?=($m["parent"] == 0)?"tr_bg_head":"tr_group_".$i?> cursor">
                                <td width="250">                            
                                   <? if($m["parent"] == 0): ?>
                                   <?=$m["name"]?>
                                   <?else:?>
                                   <div class="menu_sub">-------- <?=$m["name"]?></div>                                    
                                   <?endif;?>
                                </td>
                                <td>                                                                                                               
                                    <label class="label_inline">Read
                                    <input type="radio" name="ckbox_<?=$m["id"]?>" class="ckb_444" value="<?=$m["id"]?>_444" onchange="return checkbox_change(<?=$m["parent"].",".$i?>,'444',this)"
                                    <?=((in_array($m["id"],$map) && $this->user->menu_chmod($m["id"], array($row->id)) == 444) || (isset($row) && $row->id == 0))?"checked='checked'":""?> />
                                    </label>
                                    <label class="label_inline label_inline_last">Write    
                                    <input type="radio" name="ckbox_<?=$m["id"]?>" class="ckb_777"  value="<?=$m["id"]?>_777" onchange="return checkbox_change(<?=$m["parent"].",".$i?>,'777',this)"
                                    <?=((in_array($m["id"],$map) && $this->user->menu_chmod($m["id"], array($row->id)) == 777) || (isset($row) && $row->id == 0))?"checked='checked'":""?> />
                                    </label>  
                                    
                                    <img style="display: none;" class="img_radio_remove" onclick="return remove_radio_selected(<?=$i?>, this)" src="<?=PREFIX?>images/admin/del2.png" width="14"/>
                                                                                                 
                                </td>
                            </tr>
                            <?}?>
                       </table> 
                       <input type="hidden" id="role_ids" name="role_ids" value=""/>
                  </div>
                  </form>
            </div>
        </section>
    </div>
</div>
<?endif;?>
