<?php

defined('C5_EXECUTE') or die("Access Denied.");

class RemoteDocPageTypeController extends Controller {

    private $pkg;

    public function __construct() {
        parent::__construct();

        // initialize package object
        $this->pkg = Package::getByHandle('remo_remote_doc');
    }

    /**
     * Renders the first page from the remote/master server
     */
    public function view() {
        $this->renderRemotePage('');
    }

    /**
     * Since we don't know the names and paths of the pages on the remote/master
     * server, we have to use a dynamic method which will be called for all
     * sub pages we want to render.
     * 
     * @param type $name
     * @param type $arguments
     */
    public function __call($name, $arguments) {
        $path = '/' . join('/', $arguments);
        $this->renderRemotePage($path);
    }

    /**
     * This methods takes the path of the page on the master server
     * which you want to fetch.
     * 
     * In combination with the value of the two attributes remote_doc_url
     * and remote_doc_base it will pull the content from the remote server.
     * 
     * Example:
     *    page: http://www.node.com/documentation/
     * 
     *    attributes:
     *       remote_doc_url http://www.remoteserver.com
     *       remote_doc_base /doc
     * 
     * The first call will pull the relevant blocks from http://www.remoteserver.com/doc
     * and display them on this server. The links on the remote server
     * will be replaced to make sure that subsequent calls to subpages like
     * http://www.remoteserver.com/doc/installation are directed through the
     * __call method above.
     * 
     * All the paths are mapped from the master server to every single node.
     * http://www.remoteserver.com/doc/installation on the master server turns
     * into http://www.node.com/documentation/installation on the node.
     * 
     * @param string $path path of the page to render
     */
    private function renderRemotePage($path) {
        $nh = Loader::helper('navigation');
        $jh = Loader::helper('json');
        $c = Page::getCurrentPage();
        $remoteDocUrl = $c->getAttribute('remote_doc_url');
        $remoteDocBase = $c->getAttribute('remote_doc_base');
        
        if ($remoteDocUrl == '') {
            $this->set('docContent', t('Please specify the remote doc server in the attributes remote_doc_url and remote_doc_base.'));
            return;
        }
        
        $docJson = file_get_contents($remoteDocUrl . '/index.php/tools/packages/remo_remote_doc/get_content?docPath=' . $remoteDocBase . $path);
        $docObj = $jh->decode($docJson);
        
        $docContent = $docObj->content;
        $docHeaderElements = $docObj->headerElements;
        if (is_array($docHeaderElements)) {
            foreach ($docHeaderElements as $docHeaderElement) {
                $this->addHeaderItem($docHeaderElement);
            }
        }
        
        // replace relative links
        $docContent = str_replace($remoteDocBase . '/', $nh->getLinkToCollection($c), $docContent);
        
        $this->set('docContent', $docContent);
    }

}