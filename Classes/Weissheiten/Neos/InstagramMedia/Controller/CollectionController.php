<?php
namespace Weissheiten\Neos\InstagramMedia\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Weissheiten.Neos.InstagramMedia".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class CollectionController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('foos', array(
			'zonk', 'narf'
		));
	}

	public function createCollection(){

	}

}