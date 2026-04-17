# PHP Multiple Image Upload with Resize, Watermark, Thumbnail & AJAX (Dropzone)

This is a simple PHP-based image upload class that allows you to:

- Upload multiple images using AJAX (Dropzone.js)
- Resize images
- Change image quality
- Add watermark
- Set watermark position (X-Y axis)
- Validate image size before upload
- Rename uploaded images
- Create thumbnails from original images
- Store image names for database insertion

---

## 🚀 Features

- Multiple file upload support
- Dropzone.js integration
- Image resizing
- Image compression (quality control)
- Watermark support
- Thumbnail generation
- File renaming option
- Minimum image size validation
- Easy database integration

---

## 📁 Frontend Setup (Dropzone.js)

### HTML

```html
<div class="dropzone dz-clickable" id="myDrop">
    <div class="dz-default dz-message" data-dz-message="">
        <span>Drop files here to upload</span>
    </div>
</div>

<button id="add_file">Upload Files</button>

<div id="msg"></div>
```

### Javascript

```js
Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("div#myDrop", {
    paramName: "files", // name used to send file to server
    addRemoveLinks: true,
    uploadMultiple: true,
    autoProcessQueue: false,
    parallelUploads: 50,
    maxFilesize: 10, // MB
    acceptedFiles: ".png, .jpeg, .jpg, .gif",
    url: "ajax/actions.ajax.php",
});

/* Success Event */
myDropzone.on("success", function(file, message){
    $("#msg").html(message);
    setTimeout(function(){
        window.location.href="index.php"
    }, 800);
});

/* Error Event */
myDropzone.on("error", function () {
    $("#msg").html('<div class="alert alert-danger">Something went wrong, please try again!</div>');
});

/* Remove file after upload */
myDropzone.on("complete", function(file) {
    myDropzone.removeFile(file);
});

/* Manual Upload Trigger */
$("#add_file").on("click", function (){
    myDropzone.processQueue();
});
```

### Backend (PHP Upload Handler)

```php
<?php
require('../az.multi.upload.class.php');

$rename = rand() . time(); // custom file name

$upload = new ImageUploadAndResize(); // create object

$upload->uploadFiles(
    'files',                 // Dropzone paramName
    '../uploads',            // destination folder
    true,                    // create thumbnail (true/false)
    250,                     // minimum image width
    '../mini-logo.png',     // watermark image path
    20,                      // watermark X position
    20,                      // watermark Y position
    $rename,                 // rename file
    0777,                    // folder permission
    100,                     // image quality (1–100)
    '850',                   // new image width (resize)
    '250'                    // thumbnail width
);
?>
```


## 🧠 uploadFiles() Parameters Explained

| Parameter | Default | Description |
|----------|--------|-------------|
| `$yourFileName` | — | Dropzone paramName |
| `$yourDestination` | — | Upload directory path |
| `$createThumb` | false | Create thumbnail folder & files |
| `$minImgWidth` | 400 | Minimum allowed image width |
| `$waterMarkImgSrc` | empty | Watermark image path |
| `$xPosition` | empty | Watermark X-axis position |
| `$yPosition` | empty | Watermark Y-axis position |
| `$reName` | empty | Rename uploaded file |
| `$permission` | 0655 | Folder permissions |
| `$quality` | 100 | Image quality (1–100) |
| `$newWidth` | empty | Resize main image width |
| `$thumbWidth` | empty | Thumbnail width |

---

## 🗄️ Save Uploaded Images to Database

After upload, the class returns an array of image names:

```php
<?php
$db = new mysqli('localhost','root','','test');

echo "<pre>";

foreach($upload->prepareNames as $name){

    $sql = "INSERT INTO YOURTABLE_NAME (YOUR_COL_NAME) 
            VALUES ('".$name."')";

    if ($db->query($sql) === TRUE) {
        echo "Record inserted successfully\n";
    } else {
        echo "Error: " . $sql . "\n" . $db->error;
    }
}

echo "</pre>";
?>
```


### Folder Structure Example
```
project/
│
├── ajax/
│   └── actions.ajax.php
│
├── uploads/
├── thumbnails/
├── az.multi.upload.class.php
├── index.php
```

### 🎯 Use Cases
E-commerce product image upload
Profile image upload system
CMS media manager
Gallery systems
📌 Notes
Ensure GD Library is enabled in PHP
Set correct folder permissions (0777 recommended for testing)
Adjust upload limits in php.ini if needed:
upload_max_filesize
post_max_size
📜 License

Free to use for personal and commercial projects.

⭐ Support

If you like this project, give it a ⭐ on GitHub and share it with others!

