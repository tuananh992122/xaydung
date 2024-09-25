
<script src="https://cdn.ckeditor.com/4.7.1/full/ckeditor.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		url= '<?=PREFIX?>includes/assets/ckfinder/';

	   $('.mceEditor').each(function(e){
	       CKEDITOR.replace( this.id, {

    			height:350,
                width:800,
    			// Configure your file manager integration. This example uses CKFinder 3 for PHP.
    
                filebrowserBrowseUrl: url+'ajt723100snvnhas1.html',
    
                filebrowserImageBrowseUrl: url+'ajt723100snvnhas1.html?type=Images',
    
                filebrowserUploadUrl: url+'core/connector/php/connector.php?command=QuickUpload&type=Files',
    
                filebrowserImageUploadUrl: url+'core/connector/php/connector.php?command=QuickUpload&type=Images'
    
    		} );  
	   })

	}); 

</script>