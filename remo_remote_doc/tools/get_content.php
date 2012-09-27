<?php

$th = Loader::helper('text');

$docPath = $th->sanitize($_REQUEST['docPath']);

// TODO add some kind of security check, only show pages visible to group xy..

$p = Page::getByPath($docPath);
$blocks = $p->getBlocks();

foreach ($blocks as $block) {
    // TODO we don't care about JavaScripts at this point, they would probably
    // break anyways... To be verified..
    if (in_array($block->getBlockTypeHandle(), array('content'))) {
        $block->display();
    }
}

?>