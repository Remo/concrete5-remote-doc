<?php
defined('C5_EXECUTE') or die("Access Denied.");

class RemoRemoteDocPackage extends Package {

    protected $pkgHandle = 'remo_remote_doc';
    protected $appVersionRequired = '5.6.0';
    protected $pkgVersion = '0.0.4';
    private $pkg;

    public function getPackageName() {
        return t("Remote Doc");
    }

    public function getPackageDescription() {
        return t("Installs the Remote Doc Package.");
    }

    public function install() {
        $this->pkg = parent::install();

        // Install page types
        Loader::model('collection_types');
        $ct = CollectionType::getByHandle('remote_doc');
        if ((!is_object($ct)) || ($ct->getCollectionTypeID() < 1)) {
            $data['ctHandle'] = 'remote_doc';
            $data['ctName'] = t('Remote Doc');
            CollectionType::add($data, $this->pkg);
        }
        
        // Install blocks
        BlockType::installBlockTypeFromPackage('remo_remote_comment', $this->pkg);
        
    }

    public function upgrade() {
        parent::upgrade();
        
        $this->pkg = Package::getByHandle($this->pkgHandle);
                
    }

}