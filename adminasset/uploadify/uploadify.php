<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/public/uploads'; // Relative to the root
$newdir = '/'.date('Ymd',time());
$str = 'abcdefghijklmnopqrstuvwxyz0123456789';
$imgurl = time().substr(str_shuffle($str),0,5);
$targetFolder .= $newdir;
if(!is_dir('../..'.$targetFolder)){
	@mkdir('../..'.$targetFolder);
	chmod('../..'.$targetFolder,0777);
}

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	//$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];	
	$targetFile = rtrim($targetPath,'/') . '/' .$imgurl;
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // 图片类型限制
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	$targetFile = $targetFile.'.'.$fileParts['extension'];
	
	if (in_array($fileParts['extension'],$fileTypes)) {		
		move_uploaded_file($tempFile,$targetFile);		
		echo $targetFolder.'/'.$imgurl.'.'.$fileParts['extension'];
	} else {
		move_uploaded_file($tempFile,$targetFile);
		echo $targetFolder.'/'.$imgurl.'.'.$fileParts['extension'];
	}
}
?>
