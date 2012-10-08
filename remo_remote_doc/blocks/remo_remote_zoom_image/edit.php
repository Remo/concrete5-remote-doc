<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
$includeAssetLibrary = true; 
$assetLibraryPassThru = array(
	'type' => 'image'
);
	$al = Loader::helper('concrete/asset_library');

$bf = null;

if ($controller->getFileID() > 0) { 
	$bf = $controller->getFileObject();
}

$altText         = $controller->altText;
$thumbnailWidth  = $controller->thumbnailWidth;
$thumbnailHeight = $controller->thumbnailHeight;

include('form.php');


?>