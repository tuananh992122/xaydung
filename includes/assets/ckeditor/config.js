/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	 var url = $('#base_url').val();
	
    config.enterMode = CKEDITOR.ENTER_BR;
    config.filebrowserBrowseUrl = url+ 'assets/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl =url+  'assets/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = url+ 'assets/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = url+ 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl =url+  'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl =url+  'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

};
