<?php     

defined('C5_EXECUTE') or die(_("Access Denied."));
$includeAssetLibrary = true;
$assetLibraryPassThru = array(
	'type' => 'image'
);
$al = Loader::helper('concrete/asset_library');
$bf = null;

$altText = '';
$thumbnailWidth = 200;
$thumbnailHeight = 200;

include('form.php');
?>
