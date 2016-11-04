<?php 
private function syncPhotoToS3($filePath){
    	$siteConf = Zandy_Registry::get('siteConf');
    	include_once $siteConf['libDir'] . '/aws/sdk.class.php';
    	
    	$s3 = new AmazonS3($siteConf['aws_config']['AWS_KEY'],
    			$siteConf['aws_config']['AWS_SECRET_KEY']);
    	$originPath = $siteConf['upimg_folder'] . 'upimg/';
    	$fileUrl = $originPath.$filePath;
    	$content = file_get_contents($fileUrl);
    	$fileCons = exif_imagetype($fileUrl);
    	$fileType = image_type_to_mime_type($fileCons);
    	$res = $s3->create_object("jjshouseimg", "upimg/" . $filePath, array(
    			"body" => $content,
    			"acl" => AmazonS3::ACL_PUBLIC,
    			"contentType" => $fileType,
    	));
    	return $res;
    }

