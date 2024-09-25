$(document).ready(function(){
    $('.amount').formatCurrency({roundToDecimalPlace: 0,symbol:'',digitGroupSymbol:','});
    $(".amount").keyup(function(){
        $('.amount').formatCurrency({roundToDecimalPlace: 0,symbol:''});
    }) 
    
    $('#cat_level_area').find('span').click(function(){
        $('#cat_level_area').find('i').removeClass('fa-circle');
        $(this).find('i').addClass('fa-circle');
        var id = $(this).find('i').attr('id');
        id = id.split('_');
        $('#cat_id').val(id[1]);
    })    
})

function size_add(){
    var html = $('#size_master').html();
    $('#size_child').append(html);
    return false;
}

function size_del(o){
    $(o).parent('.size_item').remove();
    return false;
}

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
    
    //Category
    var cat_id = $('#cat_id').val();
    if(cat_id == 0){
        $('.alert').show().html('Bạn chưa chọn nhóm danh mục cho sản phẩm');
        return false;
    }     
    
    //size
    var ck_size = 0;
    var size_mix = '';
    $('#size_child').find('.size_item').each(function(){
        var name = $(this).find('input[name="size"]').val();
        var fake = $(this).find('input[name="price_fake"]').val();
        var sale = $(this).find('input[name="price_sale"]').val();
        var id = $(this).find('input[name="size_id"]').val();
        var primary = 0;
        if($(this).find('input[name="size_primary"]').is(':checked'))
            primary = 1;            
        if(name == '' || sale == '')
            ck_size++;
        else
            size_mix += name+'_keke_'+fake+'_keke_'+sale+'_keke_'+id+'_keke_'+primary+'_xkekex_';    
    })
    if(ck_size > 0){
        $('.alert').show().html('Đơn giá và size không được để trống.');
        return false;
    }
    $('#size_mix').val(size_mix);
   
}