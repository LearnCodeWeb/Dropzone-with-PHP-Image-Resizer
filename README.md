# Multi Files Uploader PHP

1) Resize Images
2) Change quality of images
3) Add watermark
4) Set watermark position x-y
5) Check uploading imaegs size
6) Rename images

----------------
This is very basic class that you can use for upload images.

By using this class you can change the ***QUALITY*** of the image, Add water mark and you also can ***RESIZE*** the image.

You just need to set the name of your files in a **Dropzone** *like*

**paramName: "files",** // The name that will be used to transfer the file

for dropzone read [https://github.com/enyo/dropzone]

in your PHP file

```php
require('../az.multi.upload.class.php');
$rename	=	rand().time(); // You can choose your own name.
$upload	=	new ImageUploadAndResize(); // Object create
$upload->uploadFiles('files', '../uploads', 400, '../mini-logo.png', 20, 20, $rename, 0777, 100, '');
```
After upload images method will return images Name array that you can use to submit into **DB TABLE** like.

```
$db		=	new mysqli('localhost','root','','test');

print"<pre>";
foreach($upload->prepareNames as $name){
	$sql = "INSERT INTO YOURTABLE_NAME (YOUR_COL_NAME) VALUES ('".$name."')";
	
	if ($db->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $db->error;
	}
}
print"</pre>";
```

All parameters that you need to set

```php
$yourFileName = 'Your paramName' // Set in a Dropzone
$yourDestination  = '../upload' // Folder/Dir name where you need to save images
$minImgWidth  = 400 //Set to check Minimum width of uploaded images.
$waterMarkImgSrc  = '../mini-logo.png' //Set watermark
$xPosition  = 20 //Set position of watermark X-AXIS
$yPosition  = 20 //Set position of watermark Y-AXIS
$reName = 'Rename uploaded file if you need' // Left empty save file default name
$permission = 0655 // Folder/Dir permission set 0777 for full access
$quality  = 100 // Set image quality you can set it between 1-100
$newWidth = '' // If you want to resize the image then pass int value else upload without resizing
```

Thank you

Regards Zaid Bin Khalid
