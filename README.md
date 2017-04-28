# Files uploader with Resize & change quality of images

----------------
This is very basic class that you can use for upload images.

By using this class you can change the ***QUALITY*** of the image and you also can ***RESIZE*** the image.

You just need to set the name of your files in a **Dropzone** *like*

**paramName: "files",** // The name that will be used to transfer the file

for dropzone read [https://github.com/enyo/dropzone]

in your PHP file

```php
require('../az.multi.upload.class.php');
$rename	=	rand().time(); // You can choose your own name.
$upload	=	new ImageUploadAndResize();
$upload->uploadFiles('files',$rename,'../uploads',0777,100,'');
```
All parameters that you need to set

```php
$yourFileName = 'Your paramName' // Set in a Dropzone
$reName = 'Rename uploaded file if you need' // Left empty save file default name
$yourDestination  = '../upload' // Folder/Dir name where you need to save images
$permission = 0655 // Folder/Dir permission set 0777 for full access
$quality  = 100 // Set image quality you can set it between 1-100
$newWidth = '' // If you want to resize the image then pass int value else upload without resizing
```

Thank you

Regards Zaid Bin Khalid
