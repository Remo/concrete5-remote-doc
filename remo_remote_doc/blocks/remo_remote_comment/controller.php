<?php

defined('C5_EXECUTE') or die('Access Denied.');

class RemoRemoteCommentBlockController extends BlockController {

    protected $btTable = 'btRemoRemoteComment';
    protected $btInterfaceWidth = "600";
    protected $btInterfaceHeight = "465";
    protected $filesetname;

    public function getBlockTypeDescription() {
        return t("Remote Comment.");
    }

    public function getBlockTypeName() {
        return t("Remote Comment");
    }

    function save($args) {

        parent::save($args);
    }

    public function add() {
        
    }

    public function edit() {
        
    }

    public function view() {        
        $th = Loader::helper('concrete/urls');
        $this->set('actionUrl', BASE_URL . $th->getToolsURL('post_comment', 'remo_remote_doc'));  

        $db = Loader::db();
        $comments = $db->GetAll('SELECT comment FROM btRemoRemoteCommentComment WHERE bID=? ORDER BY mID desc', array($this->bID));
        $this->set('comments', $comments);
    }

}