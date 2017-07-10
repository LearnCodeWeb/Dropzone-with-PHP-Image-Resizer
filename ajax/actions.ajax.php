<?php
// If necessary then set these
/*ini_set('post_max_size', '1000M');
ini_set('upload_max_filesize', '1000M');
ini_set('memory_limit','1000M');*/

require('../az.multi.upload.class.php');
$rename	=	rand(1000,5000).time();
$upload	=	new ImageUploadAndResize('localhost','root','','test');
$upload->uploadFiles('files', '../uploads', 250, '../mini-logo.png', 20, 20, $rename, 0777, 100, '');
