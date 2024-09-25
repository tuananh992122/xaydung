function cleanHTML(input) {
  // 1. remove line breaks / Mso classes
  var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g; 
  var output = input.replace(stringStripper, ' ');
  // 2. strip Word generated HTML comments
  var commentSripper = new RegExp('<!--(.*?)-->','g');
  var output = output.replace(commentSripper, '');
  var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>','gi');
  // 3. remove tags leave content if any
  output = output.replace(tagStripper, '');
  // 4. Remove everything in between and including tags '<style(.)style(.)>'
  var badTags = ['style', 'script','applet','embed','noframes','noscript'];
  
  for (var i=0; i< badTags.length; i++) {
    tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
    output = output.replace(tagStripper, '');
  }
  // 5. remove attributes ' style="..."'
  var badAttributes = ['style', 'start'];
  for (var i=0; i< badAttributes.length; i++) {
    var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
    output = output.replace(attributeStripper, '');
  }
  return output;
}

/** String to Slug **/
function stringToSlug(str){
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();
    
    // remove accents, swap ñ for n, etc
    var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
    var to   = "aaaaaeeeeeiiiiooooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    
    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes
    
    return str;
}

/** slug to unslug **/
function unslug(str){
    var str_exp = str.split('-');
    var len = str_exp.length;
    var new_str = '';
    if(len > 0){
        for(var i =0; i< len; i++){
            if(!parseInt(str_exp[i]))
                new_str += str_exp[i];
        }
        return new_str;    
    }else
        return str;    
}

/** Validate image extension **/
function validate_file(id){
    var fileSize = $("#"+id)[0].files[0].fileSize;
    var maxSize = 10097152;
    if(/.*\.(pdf)|(xls)|(ppt)|(doc)|(docx)|(pptx)|(xlsx)$/.test($("#"+id).val().toLowerCase())== false)
    {
        $('#'+id).val('');
        alert("Vui lòng chỉ upload file định dạng sau: pdf, xls, ppt, doc, docx, xlsx, pptx");        
        return false
    }
    else if( fileSize > maxSize){
        $('#'+id).val('');
        alert("File upload phải có dung lượng < 10MB");        
        return false;
    }
}

function check_user(user){
    var reg = /^[A-Za-z][A-Za-z0-9_]+$/;
    var ck = reg.test(user);
    return ck; 
}


function divOnfocus(o,text){
    var u = $(o).html();
    if(u == text)
        $(o).html('');
    return false;
}

function divOnblur(o,text){
    var u = $(o).html();
    if(u == '')
        $(o).html(text);
    return false;
}

function get_domain_from_url(url){
    var str = url.replace('http://','').replace('https://','').replace('www.','').split(/[/?#]/)[0];
    return str;    
}

function gotoTop(){
    $('html, body').animate({scrollTop:0},1000);    
}

function change_checkbox(o){
    var u = $(o).val();
    if($(o).is(':checked'))
        $(o).val(1);
    else
        $(o).val(0);    
    return false;
}

//================= Matching function ====================//

function checkUsername(user){
    if(/^[a-z0-9_-]{3,16}$/.test(user))
        return true;
    else 
        return false;
}


function checkPassword(text){
    if(/^[a-z0-9_-]{6,18}$/.test(text))
        return true;
    else 
        return false;
}

function checkHexValue(text){
    if(/#?([a-f0-9]{6}|[a-f0-9]{3})$/.test(text))
        return true;
    else 
        return false;
}
function checkSlug(text){
    if(/^[a-z0-9-]+$/.test(text))
        return true;
    else 
        return false;
}

//Check email address
function checkEmail(email) {    
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!filter.test(email))
        return false;
    else
        return true;            
}

//Check url invalid must has http or https
function checkUrl(url){
    if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url))
        return true;
    else 
        return false;
}

//Check domain invalid accpet http or no
function checkDomain(domain){
    if(/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/.test(domain))
        return true;
    else 
        return false;
}


function checkIPAddress(text){
    if(/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(text))
        return true;
    else 
        return false;
}
function checkHTMLTag(text){
    if(/^<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)$/.test(text))
        return true;
    else 
        return false;
}

function checkFloat(text){
    if(/^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/.test(text))
        return true;
    else 
        return false;
}

//base64 Decode - Encode
!function(r){var e="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",o=function(r){r=r.replace(/\x0d\x0a/g,"\n");for(var e="",o=0;o<r.length;o++){var a=r.charCodeAt(o);128>a?e+=String.fromCharCode(a):a>127&&2048>a?(e+=String.fromCharCode(a>>6|192),e+=String.fromCharCode(63&a|128)):(e+=String.fromCharCode(a>>12|224),e+=String.fromCharCode(a>>6&63|128),e+=String.fromCharCode(63&a|128))}return e},a=function(r){for(var e="",o=0,a=c1=c2=0;o<r.length;)a=r.charCodeAt(o),128>a?(e+=String.fromCharCode(a),o++):a>191&&224>a?(c2=r.charCodeAt(o+1),e+=String.fromCharCode((31&a)<<6|63&c2),o+=2):(c2=r.charCodeAt(o+1),c3=r.charCodeAt(o+2),e+=String.fromCharCode((15&a)<<12|(63&c2)<<6|63&c3),o+=3);return e};r.extend({base64Encode:function(r){var a,t,n,c,h,C,d,f="",i=0;for(r=o(r);i<r.length;)a=r.charCodeAt(i++),t=r.charCodeAt(i++),n=r.charCodeAt(i++),c=a>>2,h=(3&a)<<4|t>>4,C=(15&t)<<2|n>>6,d=63&n,isNaN(t)?C=d=64:isNaN(n)&&(d=64),f=f+e.charAt(c)+e.charAt(h)+e.charAt(C)+e.charAt(d);return f},base64Decode:function(r){var o,t,n,c,h,C,d,f="",i=0;for(r=r.replace(/[^A-Za-z0-9\+\/\=]/g,"");i<r.length;)c=e.indexOf(r.charAt(i++)),h=e.indexOf(r.charAt(i++)),C=e.indexOf(r.charAt(i++)),d=e.indexOf(r.charAt(i++)),o=c<<2|h>>4,t=(15&h)<<4|C>>2,n=(3&C)<<6|d,f+=String.fromCharCode(o),64!=C&&(f+=String.fromCharCode(t)),64!=d&&(f+=String.fromCharCode(n));return f=a(f)}})}(jQuery);