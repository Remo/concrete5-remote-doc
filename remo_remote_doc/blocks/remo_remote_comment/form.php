<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));
$fh = Loader::helper('form');

echo $fh->checkbox('commentingEnabled', 1, $commentingEnabled);
?>


