<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Images</title>
<link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="dropzone/dropzone.css" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" type="text/css">
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</head>
<body>
	<?php
    	//deleteing images
		if(isset($_REQUEST['img']) and $_REQUEST['img']!=""){
			@unlink('uploads/'.$_REQUEST['img']);
			@unlink('uploads/thumb/'.$_REQUEST['img']);
			$msg	=	'<div class="alert alert-success">Image delete successfully.</div>';
		}
	?>
	<div class="container">
    	<div class="alert alert-warning my-2">
        	<i class="fa fa-2x fa-exclamation-circle float-right"></i>
        	<ol class="m-0">
				<li>Image uploading limit is 5.</li>
                <li>One image not more then 5MB.</li>
            </ol>
        </div>
        <!-- Place this tag where you want the button to render. -->
        <a class="github-button" href="https://github.com/learncodeweb" data-style="mega" data-show-count="true" aria-label="Follow @learncodeweb on GitHub">Follow @LCW</a>
        <!-- Place this tag where you want the button to render. -->
        <a class="github-button" href="https://github.com/learncodeweb/Dropzone-with-PHP-Image-Resizer" data-icon="octicon-star" data-style="mega" data-show-count="true" aria-label="Star learncodeweb/Dropzone-with-PHP-Image-Resizer on GitHub">Star</a>
    	<div id="msg"><?php echo isset($msg)?$msg:''; ?></div>
        <div class="card">
        	<div class="card-header"><i class="glyphicon glyphicon-upload"></i> Upload Multiple Files</div>
            <div class="card-body">
                <div class="form-group">
                	<label><strong>Resize Width</strong></label>
                    <input type="number" name="newWidth" id="newWidth" class="form-control">
                    <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Left empty for original image.</span>
                </div>
                <div class="form-group">
                    <div class="dropzone dz-clickable" id="myDrop">
                        <div class="dz-default dz-message" data-dz-message="">
                            <span>Drop files here to upload</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" id="add_file" class="btn btn-primary" name="submit"><i class="fa fa-upload"></i> Upload File(s)</button>        
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mt-3">
		<div class="card">
            <div class="card-header"><i class="glyphicon glyphicon-picture"></i> View Uploaded Files</div>
            <div class="card-body" style="overflow-y: scroll">
            	<div class="card-columns">
					<?php
                    $directory = 'uploads/thumb';
                    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
                    foreach($scanned_directory as $img){
                    ?>
                    <div class="card">
                       <a href="uploads/<?php echo $img; ?>" data-fancybox="true"> <img src="uploads/thumb/<?php echo $img; ?>" alt="<?php echo $img; ?>" class="img-thumbnail"></a>
                        <div class="card-body">
                            <a href="index.php?img=<?php echo $img; ?>" class="btn btn-block btn-danger"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
	</div>
    
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <!--Only these JS files are necessary--> 
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>
    <script src="dropzone/dropzone.js"></script>
    <script>
	//Dropzone script
	Dropzone.autoDiscover = false;
	var myDropzone = new Dropzone("div#myDrop", 
	 { 
		 paramName: "files", // The name that will be used to transfer the file
		 addRemoveLinks: true,
		 uploadMultiple: true,
		 autoProcessQueue: false,
		 parallelUploads: 50,
		 maxFilesize: 30, // MB
		 acceptedFiles: ".png, .jpeg, .jpg, .gif",
		 url: "ajax/actions.ajax.php",
	 });

	 
	 /* Add Files Script*/
	 myDropzone.on("success", function(file, message){
		$("#msg").html(message);
		setTimeout(function(){window.location.href="index.php"},800);
	 });
	 
	 myDropzone.on("error", function (data) {
		 $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
	 });
	 
	 myDropzone.on("complete", function(file) {
		myDropzone.removeFile(file);
	 });
	 
	 $("#add_file").on("click",function (){
		myDropzone.processQueue();
	 });
	</script>   
</body>
</html>
