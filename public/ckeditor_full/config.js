/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// config.height = '500px';
	config.filebrowserBrowseUrl = './ckeditor_full/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = './ckeditor_full/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = './ckeditor_full/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = './ckfinder_full/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = './ckeditor_full/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = './ckeditor_full/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	
};
