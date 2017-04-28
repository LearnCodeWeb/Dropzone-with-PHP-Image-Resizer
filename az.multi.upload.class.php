<?php
class ImageUploadAndResize{
	
	private $newWidth;
	private $folderName;
	public $n			=	0;
	public $s			=	0;
	public $Sflag		=	0;
	
	public function compressImage($sourceURL, $destinationURL, $quality, $newWidth) {
		$infoImg 	= 	getimagesize($sourceURL);
		$width		=	$infoImg[0];
		$height		=	$infoImg[1];
		if($newWidth!=""){
			$diff 		= 	$width / $newWidth;
			$newHeight 	= 	$height / $diff; // creating new width and height with aspect ratio
		}else{
			$newWidth 	= 	$width;
			$newHeight 	= 	$height;
		}
		
		$imgResource 		= 	imagecreatetruecolor($newWidth, $newHeight);
		if ($infoImg['mime'] == 'image/jpeg'){
			$image = imagecreatefromjpeg($sourceURL);
			imagecopyresampled($imgResource, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		} elseif ($infoImg['mime'] == 'image/png'){
			$image = imagecreatefrompng($sourceURL);
			imagecopyresampled($imgResource, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		} elseif ($infoImg['mime'] == 'image/gif'){
			$image = imagecreatefrompng($sourceURL);
			imagecopyresampled($imgResource, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		} elseif ($infoImg['mime'] == 'image/jpg'){
			$image = imagecreatefrompng($sourceURL);
			imagecopyresampled($imgResource, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		}
		$RET	=	imagejpeg($imgResource, $destinationURL, $quality);
		imagedestroy($image);
		return $RET;
	}
	
	public function createDir($folderName, $permission){
		if(!file_exists($folderName)) {
			mkdir($folderName, $permission, true);
			$fName	=	$folderName;
		}else{
			$fName	=	$folderName;
		}
		return $fName;
	}
	
	public function uploadFiles($yourFileName, $reName="", $yourDestination, $permission=0655, $quality=100, $newWidth=""){
		if(!empty($_FILES[$yourFileName])){
			foreach($_FILES[$yourFileName]['name'] as $val)
			{
				$this->s++;
				$filesName		=	str_replace(" ","",trim($_FILES[$yourFileName]['name'][$this->n]));
				$files			=	explode(".",$filesName);
				$File_Ext   	=   substr($_FILES[$yourFileName]['name'][$this->n], strrpos($_FILES[$yourFileName]['name'][$this->n],'.'));
				
				if($File_Ext==".png" || $File_Ext==".jpeg" || $File_Ext==".gif" || $File_Ext==".jpg")
				{
					$srcPath	=	self::createDir($yourDestination, $permission).'/';
					if($reName!=""){
						$fileName	=	$this->s.$reName.$File_Ext;
					}else{
						$fileName	=	$files[0].$File_Ext;
					}
					$path		=	trim($srcPath.$fileName);
					if(self::compressImage($_FILES[$yourFileName]['tmp_name'][$this->n], $path, $quality, $newWidth))
					{					
						$this->Sflag	= 1; // success
					}else{
						$this->Sflag	= 2; // file not move to the destination
					}
				}
				else
				{
					$this->Sflag	= 3; //extention not valid
				}
				$this->n++;
			}
			if($this->Sflag==1){
			echo '<div class="alert alert-success">Images uploaded successfully!</div>';
			}else if($this->Sflag==2){
				echo '<div class="alert alert-danger">File not move to the destination.</div>';
			}else if($this->Sflag==3){
				echo '<div class="alert alert-success">File extention not good.</div>';
			}
		}
	}
}
?>