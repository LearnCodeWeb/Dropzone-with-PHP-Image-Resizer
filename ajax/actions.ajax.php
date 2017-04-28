<?php
// If necessary then set these
/*ini_set('post_max_size', '1000M');
ini_set('upload_max_filesize', '1000M');
ini_set('memory_limit','1000M');*/

require('../az.multi.upload.class.php');
$rename	=	rand().time();
$upload	=	new ImageUploadAndResize();
$upload->uploadFiles('files',$rename,'../uploads',0777,100,'');