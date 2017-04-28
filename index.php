<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Images</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="dropzone/dropzone.css" type="text/css">
</head>
<body>
	
	<div class="container">
    	<h4>If you like :) then, Give star to this project.</h4>
    	<div id="msg"></div>
        <div class="panel panel-default">
        	<div class="panel-heading"><i class="glyphicon glyphicon-upload"></i> Upload Multiple Files</div>
            <div class="panel-body">
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
    <!--Only these JS files are necessary--> 
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
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
		 maxFilesize: 2, // MB
		 acceptedFiles: ".png, .jpeg, .jpg, .gif",
		 url: "ajax/actions.ajax.php",
	 });

	 
	 /* Add Files Script*/
	 myDropzone.on("success", function(file, message){
		$("#msg").html(message);
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
