<?php
namespace Weissheiten\Neos\InstagramMedia\Controller;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Weissheiten.Neos.InstagramMedia".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Mvc\ActionRequest;
use Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection;
use Weissheiten\OAuth2\ClientInstagram\Endpoint;
use Weissheiten\OAuth2\ClientInstagram\Token;

class CollectionController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @Flow\Inject
	 * @var \Weissheiten\Neos\InstagramMedia\Service\TokenStorage
	 */
	protected $tokenStorage;

	/**
	 * @Flow\Inject
	 * @var \Weissheiten\Neos\InstagramMedia\Service\InstagramService
	 */
	protected $instagramService;

	/**
	 * @Flow\Inject
	 * @var \Weissheiten\Neos\InstagramMedia\Domain\Repository\InstagramCollectionRepository
	 */
	protected $instagramCollectionRepository;


    /**
     * @Flow\Inject
     * @var  Endpoint\InstagramTokenEndpoint
     */
    protected $instagramTokenEndpoint;


	/**
	 * Tries to authenticate the given token. Sets isAuthenticated to TRUE if authentication succeeded.
     *
     * @return void
	 */
	public function authenticateInstagramAction(){
        /** @var ActionRequest $actionRequest */
        $actionRequest = $this->controllerContext->getRequest();
        $authToken = new \Weissheiten\OAuth2\ClientInstagram\Token\InstagramToken();
		$authToken->updateCredentials($actionRequest);

        \TYPO3\Flow\var_dump($authToken->getCredentials());



		//				$this->redirect('index', 'Backend\Backend');



	}

	/**
	 * Show a list of InstagramCollections and their properties
	 *
	 * @return void
	 */
	public function indexAction() {
		$instagramCollections = $this->instagramCollectionRepository->findAll();


		$this->view->assignMultiple(array(
			'instagramCollections' => $instagramCollections,
			'token' => $this->instagramService->getInstagramClient()->isTokenSet()

		));

		$this->view->assign('instagramCollections',$instagramCollections);
	}

	/*
	 * Create a new InstagramCollection
	 *
	 * @param InstagramCollection $instagramCollection
	 * @return void
	 */
	public function createAction(InstagramCollection $instagramCollection){
        if($this->persistenceManager->isNewObject($instagramCollection)){
			$this->instagramCollectionRepository->add($instagramCollection);
		}
		$this->addFlashMessage(sprintf('InstagramCollection "%s" has been added.', htmlspecialchars($instagramCollection->getTitle())));
		$this->redirect('index', null, null, array(), 0, 201);
	}

    /*
     * Edit the given Instagram Collection
     *
     * @param InstagramCollection $instagramCollection
     * @return void
     *
     */
    public function editCollectionAction(InstagramCollection $instagramCollection){
        $this->view->assign('instagramCollection',$instagramCollection);
    }

    public function updateAction(InstagramCollection $instagramCollection){
        $this->instagramCollectionRepository->update($instagramCollection);
        $this->addFlashMessage('The Instagram Collection "%s" has been updated.', 'User updated', Message::SEVERITY_OK, array($instagramCollection->getTitle()), 1412374498);
        $this->redirect('index');
    }

    /*
     * Delete an InstagramCollection
     *
     * @param InstagramCollection $instagramCollection
     * @return void
     */
    public function deleteAction(InstagramCollection $instagramCollection){
        \TYPO3\FLOW\var_dump($instagramCollection);
        /*
        $this->instagramCollectionRepository->remove($instagramCollection);
        $this->addFlashMessage(sprintf('Collection "%s" has been deleted.', htmlspecialchars($instagramCollection->getTitle())));
         */
        $this->redirect('index');

    }

}