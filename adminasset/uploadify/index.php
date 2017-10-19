<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>文件上传</title>
<script src="/asset/admin/js/jquery.js" type="text/javascript"></script>
<script src="jquery.uploadify.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="uploadify.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
</style>
</head>

<body>
	<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
	</form>

<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'fileSizeLimit' : '1MB', //300M
				'fileTypeExts' : '*.gif; *.jpg; *.png',
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : 'uploadify.swf',
				'uploader' : 'uploadify.php',
				'onUploadSuccess' : function(file, data, response){
                     $('#imgurl').val(data);
                     art.dialog({time:1,title:'消息',content:file.name+'上传成功'});
                     }
			});
		});
	</script>
	<input type="hidden" id="imgurl" value="">
	<link rel="stylesheet" type="text/css" media="all" href="/asset/admin/js/artDialog/skins/default.css" />
<link rel="stylesheet" type="text/css" media="all" href="/asset/admin/js/css/ui-lightness/jquery-ui.css" />
<script src="/asset/admin/js/artDialog/artDialog.js"></script>
<script src="/asset/admin/js/artDialog/iframeTools.source.js"></script>
</body>
</html>
