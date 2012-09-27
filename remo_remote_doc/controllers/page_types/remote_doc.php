<?php

defined('C5_EXECUTE') or die("Access Denied.");

class RemoteDocPageTypeController extends Controller {

    private $pkg;

    public function __construct() {
        parent::__construct();

        // initialize package object
        $this->pkg = Package::getByHandle('remo_remote_doc');
    }

    public function view() {
        $this->renderRemotePage('');
    }
    
    public function __call($name, $arguments) {
        $path = '/' . join('/', $arguments);
        $this->renderRemotePage($path);
    }

    private function renderRemotePage($path) {
        $nh = Loader::helper('navigation');
        $c = Page::getCurrentPage();
        $remoteDocUrl = $c->getAttribute('remote_doc_url');
        $remoteDocBase = $c->getAttribute('remote_doc_base');
        
        $docContent = file_get_contents($remoteDocUrl . '/index.php/tools/packages/remo_remote_doc/get_content?docPath=' . $remoteDocBase . $path);
        
        // replace absolute links
        $docContent = str_replace($remoteDocUrl . $remoteDocBase, $nh->getLinkToCollection($c), $docContent);
        // replace relative links
        $docContent = str_replace($remoteDocBase, $nh->getLinkToCollection($c), $docContent);
        
        $this->set('docContent', $docContent );    
    }
    
}