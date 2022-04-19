# Resize and Upload multiple images using PHP and Ajax

Multiple Files Uploaded in PHP.

1. Resize Images
2. Change the quality of images
3. Add watermark
4. Set watermark position x-y
5. Check to upload image size
6. Rename images
7. Create thumbnail with the original image **[New feature added]**


```php
    $yourFileName = 'Your paramName' // Set in a Dropzone
    $yourDestination  = '../upload' // Folder/Dir name where you need to save images
    $createThumb  =  false; // This is set default
    $minImgWidth  = 400 //Set to check Minimum width of uploaded images.
    $waterMarkImgSrc  = '../mini-logo.png' //Set watermark
    $xPosition  = 20 //Set position of watermark X-AXIS
    $yPosition  = 20 //Set position of watermark Y-AXIS
    $reName = 'Rename uploaded file if you need' // Left empty save file default name
    $permission = 0655 // Folder/Dir permission set 0777 for full access
    $quality  = 100 // Set image quality you can set it between 1-100
    $newWidth = '' // If you want to resize the image then pass int value else upload without resizing
    $thumbWidth = //If you want to resize the image thumb then pass int value else upload without resizing image will be saved. 
```


> View online complete documentation and integration <a href="https://learncodeweb.com/web-development/resize-and-upload-multiple-images-using-php-and-ajax/" target="_blanck">Click Here</a>

> View working example <a href="https://learncodeweb.com/demo/web-development/resize-and-upload-multiple-images-using-php-and-ajax/" target="_blanck">View Demo</a>

Thank you

Regards Zaid Bin Khalid
