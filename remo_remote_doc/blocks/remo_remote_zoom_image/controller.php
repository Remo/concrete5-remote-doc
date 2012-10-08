<?php   
	Loader::block('library_file');
	
	defined('C5_EXECUTE') or die(_("Access Denied."));	
	class RemoRemoteZoomImageBlockController extends BlockController {

		protected $btInterfaceWidth = 300;
		protected $btInterfaceHeight = 320;
		protected $btTable = 'btRemoRemoteZoomImage';

		/** 
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("Adds images and onstates from the library to pages.");
		}
		
		public function getBlockTypeName() {
			return t("Zoom Image");
		}		
		
		public function getJavaScriptStrings() {
			return array(
				'image-required' => t('You must select an image.')
			);
		}
	
      public function on_page_view(){
         $html = Loader::helper('html');
         $v = View::GetInstance();
         
         $b = $this->getBlockObject();         
         $btID = $b->getBlockTypeID();
         $bt = BlockType::getByID($btID);        
         
         $uh = Loader::helper('concrete/urls');
         
         $v->addHeaderItem('<script type="text/javascript">$(document).ready(function() { $("a.zoomImage").fancyZoom({scaleImg: true, closeOnClick: true, directory:"'.$uh->getBlockTypeAssetsURL($bt).'/images"}); });</script>','CONTROLLER');
      }
      	
		function getFileID() {return $this->fID;}
		
		function getFileObject() {
    		    return File::getByID($this->fID);
		}
		
		function getAssetFileObject() {
		    return LibraryFileBlockController::getFile($this->fID);
		}		
		function getAltText() {return $this->altText;}
		
		public function save($args) {
			$args['fID'] = ($args['fID'] != '') ? $args['fID'] : 0;
			$args['displayCaption'] = ($args['displayCaption'] != '') ? $args['displayCaption'] : 0;
			parent::save($args);
		}
	}

?>