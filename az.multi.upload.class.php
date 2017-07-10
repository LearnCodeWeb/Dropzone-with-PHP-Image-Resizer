<?php
class ImageUploadAndResize{
	
	private $newWidth;
	private $folderName;
	public $n				=	0;
	public $s				=	0;
	public $Sflag			=	0;
	public $prepareNames;
	protected $isSubQuery 	= 	false;
	
	/**
     * Database credentials
     * @var string
     */
    protected $host;
    protected $username;
    protected $password;
    protected $db;
    protected $port;
	
	/**
	* @param string $host
	* @param string $username
	* @param string $password
	* @param string $db
	* @param int $port
	*/
	
	public function __construct($host = null, $username = null, $password = null, $db = null, $port = null)
    {
     	$mysqli = new mysqli($host, $username, $password, $db, $port);
		/*
		 * This is the "official" OO way to do it,
		 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
		 */
		if ($mysqli->connect_error) {
			die('Connect Error (' . $mysqli->connect_errno . ') '
					. $mysqli->connect_error);
		}
		/*
		 * Use this instead of $connect_error if you need to ensure
		 * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
		 */
		if (mysqli_connect_error()) {
			die('Connect Error (' . mysqli_connect_errno() . ') '
					. mysqli_connect_error());
		}
		$mysqli->close();   
	}
	
	public function compressImage($sourceURL, $destinationURL, $minImgWidth, $wmImageSource="", $positionX="", $positionY="", $quality, $newWidth) {
		$infoImg 	= 	getimagesize($sourceURL);
		$width		=	$infoImg[0];
		$height		=	$infoImg[1];
		if($width<$minImgWidth){
			echo '<div class="alert alert-danger">Image <strong>WIDTH</strong> is less then '.$minImgWidth.'px</div>';
			exit;
		}
		if($newWidth!=""){
			$diff 		= 	$width / $newWidth;
			$newHeight 	= 	$height / $diff; // creating new width and height with aspect ratio
		}else{
			$newWidth 	= 	$width;
			$newHeight 	= 	$height;
		}
		
		$watermark 	= 	imagecreatefrompng($wmImageSource);
		
		$imgResource 		= 	imagecreatetruecolor($newWidth, $newHeight);
		if ($infoImg['mime'] == 'image/jpeg'){
			$image 	= 	imagecreatefromjpeg($sourceURL);
			// Set the margins for the watermark and get the height/width of the watermark image
			$positionRight 	= 	$positionX;
			$positionBottom = 	$positionY;
			$sx 	= 	imagesx($watermark);
			$sy 	= 	imagesy($watermark);
			// width to calculate positioning of the watermark. 
			imagecopy($image, $watermark, imagesx($image) - $sx - $positionRight, imagesy($image) - $sy - $positionBottom, 0, 0, imagesx($watermark), imagesy($watermark));
			
			imagecopyresampled($imgResource, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		} elseif ($infoImg['mime'] == 'image/png'){
			$image 	= 	imagecreatefrompng($sourceURL);
			// Set the margins for the watermark and get the height/width of the watermark image
			$positionRight 	= 	$positionX;
			$positionBottom = 	$positionY;
			$sx 	= 	imagesx($watermark);
			$sy 	= 	imagesy($watermark);
			// width to calculate positioning of the watermark. 
			imagecopy($image, $watermark, imagesx($image) - $sx - $positionRight, imagesy($image) - $sy - $positionBottom, 0, 0, imagesx($watermark), imagesy($watermark));
			
			imagecopyresampled($imgResource, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		} elseif ($infoImg['mime'] == 'image/gif'){
			$image 	= 	imagecreatefromgif($sourceURL);
			// Set the margins for the watermark and get the height/width of the watermark image
			$positionRight 	= 	$positionX;
			$positionBottom = 	$positionY;
			$sx 	= 	imagesx($watermark);
			$sy 	= 	imagesy($watermark);
			// width to calculate positioning of the watermark. 
			imagecopy($image, $watermark, imagesx($image) - $sx - $positionRight, imagesy($image) - $sy - $positionBottom, 0, 0, imagesx($watermark), imagesy($watermark));
			
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
	
	
	public function uploadFiles($yourFileName, $yourDestination, $minImgWidth=400, $waterMarkImgSrc="", $xPosition="", $yPosition="", $reName="", $permission=0655, $quality=100, $newWidth=""){
		if(!empty($_FILES[$yourFileName])){
			foreach($_FILES[$yourFileName]['name'] as $val)
			{
				$infoExt 	= 	getimagesize($_FILES[$yourFileName]['tmp_name'][$this->n]);
				$this->s++;
				$filesName		=	str_replace(" ","",trim($_FILES[$yourFileName]['name'][$this->n]));
				$files			=	explode(".",$filesName);
				$File_Ext   	=   substr($_FILES[$yourFileName]['name'][$this->n], strrpos($_FILES[$yourFileName]['name'][$this->n],'.'));
				
				if($infoExt['mime'] == 'image/gif' || $infoExt['mime'] == 'image/jpeg' || $infoExt['mime'] == 'image/png')
				{
					$srcPath	=	self::createDir($yourDestination, $permission).'/';
					if($reName!=""){
						$fileName	=	$this->s.$reName.$File_Ext;
					}else{
						$fileName	=	$files[0].$File_Ext;
					}
					$path		=	trim($srcPath.$fileName);
					if(self::compressImage($_FILES[$yourFileName]['tmp_name'][$this->n], $path, $minImgWidth, $waterMarkImgSrc, $xPosition, $yPosition, $quality, $newWidth))
					{
						$this->prepareNames[]	=	array($fileName); //need to be fixed.
						$this->Sflag		= 	1; // success
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
				return $this->prepareNames;
			echo '<div class="alert alert-success">Images uploaded successfully!</div>';
			}else if($this->Sflag==2){
				echo '<div class="alert alert-danger">File not move to the destination.</div>';
			}else if($this->Sflag==3){
				echo '<div class="alert alert-danger">File extention not good. Try with <em>.PNG, .JPEG, .GIF, .JPG</em></div>';
			}
		}
	}
}
?>
