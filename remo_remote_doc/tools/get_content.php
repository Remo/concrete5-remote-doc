<?php

$th = Loader::helper('text');

$docPath = $th->sanitize($_REQUEST['docPath']);

// TODO add some kind of security check, only show pages visible to group xy..

$p = Page::getByPath($docPath);
global $c;
$c = $p;
$blocks = $p->getBlocks();
$headerTemplateElements = array();

ob_start();

foreach ($blocks as $block) {

    if (in_array($block->getBlockTypeHandle(), array('content', 'page_list', 'remo_remote_comment', 'remo_remote_zoom_image'))) {

        // call on_page_view for each block to process addHeaderItem calls
        $btc = $block->getInstance();
        $btc->runTask('on_page_view', array($p));
        
        // get css/js files included in the block template
        $blockViewTemplate = new BlockViewTemplate($block);
        $blockViewHeaderItems = $blockViewTemplate->getTemplateHeaderItems();
        if (is_array($blockViewHeaderItems)) {
            foreach ($blockViewHeaderItems as $headerElement) {
                if (!in_array($headerElement, $headerTemplateElements)) {
                    $headerTemplateElements[] = $headerElement;
                }
            }
        }

        // the actual block output
        $block->display();
           
    }
}
$blockOutput = ob_get_contents();
ob_end_clean();


$headerElements = array();
if (is_array($headerTemplateElements)) {
    foreach ($headerTemplateElements as $headerTemplateElement) {
        if ($headerTemplateElement instanceof JavaScriptOutputObject) {
            $href = $headerTemplateElement->href;
            if (substr($href, 0, 1) == '/') {
                $href = BASE_URL . $href;
            }
            $headerElements[] = "<script src=\"" . $href . "\"></script>";
        }
        if ($headerTemplateElement instanceof CSSOutputObject) {
            $href = $headerTemplateElement->href;
            if (substr($href, 0, 1) == '/') {
                $href = BASE_URL . $href;
            }        
            $headerElements[] = "<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"{$href}\" />";
        }         
    }
}

$v = View::getInstance();
$headerBlockElements = $v->getHeaderItems();
if (is_array($headerBlockElements)) {
    foreach ($headerBlockElements as $headerBlockElement) {
        $headerElements[] = $headerBlockElement;
    }
}

$obj = new stdclass();
$obj->headerElements = $headerElements;
$obj->content = $blockOutput;

$jh = Loader::helper('json');
echo $jh->encode($obj);

?>
