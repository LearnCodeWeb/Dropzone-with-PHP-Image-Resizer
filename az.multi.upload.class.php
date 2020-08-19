<?php
class ImageUploadAndResize
{

	private $newWidth;
	private $folderName;
	public $n		=	0;
	public $s		=	0;
	public $Sflag		=	0;
	public $prepareNames;
	protected $isSubQuery 	= 	false;

	/**
	 * Image compress and processing
	 */

	public function compressImage($sourceURL, $destinationURL, $minImgWidth, $wmImageSource = "", $positionX = "", $positionY = "", $quality, $newWidth)
	{
		$infoImg 	= 	getimagesize($sourceURL);
		$width		=	$infoImg[0];
		$height		=	$infoImg[1];
		if ($width < $minImgWidth) {
			echo '<div class="alert alert-danger">Image <strong>WIDTH</strong> is less then ' . $minImgWidth . 'px</div>';
			exit;
		}
		if ($newWidth != "") {
			$diff 		= 	$width / $newWidth;
			$newHeight 	= 	$height / $diff; // creating new width and height with aspect ratio
		} else {
			$newWidth 	= 	$width;
			$newHeight 	= 	$height;
		}

		$image	=	'';
		if ($infoImg['mime'] == 'image/jpeg') {
			$image 	= 	imagecreatefromjpeg($sourceURL);
		} elseif ($infoImg['mime'] == 'image/jpg') {
			$image 	= 	imagecreatefromjpeg($sourceURL);
		} elseif ($infoImg['mime'] == 'image/png') {
			$image 	= 	imagecreatefrompng($sourceURL);
		} elseif ($infoImg['mime'] == 'image/gif') {
			$image 	= 	imagecreatefromgif($sourceURL);
		}


		$imgResource 	= 	imagecreatetruecolor($newWidth, $newHeight);

		if (!empty($wmImageSource)) {
			$watermark 		= 	imagecreatefrompng($wmImageSource);
			// Set the margins for the watermark and get the height/width of the watermark image
			$positionRight 	= 	$positionX;
			$positionBottom = 	$positionY;
			$sx 	= 	imagesx($watermark);
			$sy 	= 	imagesy($watermark);
			// width to calculate positioning of the watermark. 
			imagecopy($image, $watermark, imagesx($image) - $sx - $positionRight, imagesy($image) - $sy - $positionBottom, 0, 0, imagesx($watermark), imagesy($watermark));
		}
		imagealphablending($imgResource, false);
		imagesavealpha($imgResource, true);

		imagecopyresampled($imgResource, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		if ($infoImg['mime'] == 'image/png' || $infoImg['mime'] == 'image/gif') {

			$newQuality	=	($quality / 10) - 1;
			imagealphablending($imgResource, false);
			imagesavealpha($imgResource, true);
			$RET	=	imagepng($imgResource, $destinationURL, $newQuality); //For png quality range is 0-9
		} else {
			$RET	=	imagejpeg($imgResource, $destinationURL, $quality);
		}
		imagedestroy($image);
		return $RET;
	}

	public function createDir($folderName, $permission)
	{
		if (!file_exists($folderName)) {
			mkdir($folderName, $permission, true);
			$fName	=	$folderName;
		} else {
			$fName	=	$folderName;
		}
		return $fName;
	}


	public function uploadFiles($yourFileName, $yourDestination, $createThumb = false, $minImgWidth = 400, $waterMarkImgSrc = "", $xPosition = "", $yPosition = "", $reName = "", $permission = 0655, $quality = 100, $newWidth = "", $thumbWidth = "")
	{
		if (!empty($_FILES[$yourFileName])) {
			if ($createThumb != "" and $createThumb === true) {
				$srcThumbPath	=	$this->createDir($yourDestination . '/thumb', $permission) . '/';
			}
			foreach ($_FILES[$yourFileName]['name'] as $val) {
				$infoExt 	= 	getimagesize($_FILES[$yourFileName]['tmp_name'][$this->n]);
				$this->s++;
				$filesName		=	str_replace(" ", "", trim($_FILES[$yourFileName]['name'][$this->n]));
				$files			=	explode(".", $filesName);
				$File_Ext   	=   substr($_FILES[$yourFileName]['name'][$this->n], strrpos($_FILES[$yourFileName]['name'][$this->n], '.'));

				if ($infoExt['mime'] == 'image/gif' || $infoExt['mime'] == 'image/jpeg' || $infoExt['mime'] == 'image/png') {
					$srcPath	=	$this->createDir($yourDestination, $permission) . '/';
					if ($reName != "") {
						$fileName	=	$this->s . $reName . $File_Ext;
					} else {
						$fileName	=	$files[0] . $File_Ext;
					}
					$path			=	trim($srcPath . $fileName);
					$thumbPath		=	trim($srcThumbPath . $fileName);
					if ($this->compressImage($_FILES[$yourFileName]['tmp_name'][$this->n], $path, $minImgWidth, $waterMarkImgSrc, $xPosition, $yPosition, $quality, $newWidth)) {

						$this->compressImage($_FILES[$yourFileName]['tmp_name'][$this->n], $thumbPath, $minImgWidth, $waterMarkImgSrc, $xPosition, $yPosition, $quality, $thumbWidth);

						$this->prepareNames[]	=	$fileName; //need to be fixed.
						$this->Sflag		= 	1; // success
					} else {
						$this->Sflag	= 2; // file not move to the destination
					}
				} else {
					$this->Sflag	= 3; //extention not valid
				}
				$this->n++;
			}
			if ($this->Sflag == 1) {
				return $this->prepareNames;
				echo '<div class="alert alert-success">Images uploaded successfully!</div>';
			} else if ($this->Sflag == 2) {
				echo '<div class="alert alert-danger">File not move to the destination.</div>';
			} else if ($this->Sflag == 3) {
				echo '<div class="alert alert-danger">File extention not good. Try with <em>.PNG, .JPEG, .GIF, .JPG</em></div>';
			}
		}
	}
}
