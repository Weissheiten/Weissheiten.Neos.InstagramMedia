<?php
namespace Weissheiten\Neos\InstagramMedia\Controller;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Weissheiten.Neos.InstagramMedia".*
 *                                                                        *
 *                                                                        */

use Flowpack\OAuth2\Client\Exception;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Mvc\ActionRequest;
use Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection;
use Weissheiten\OAuth2\ClientInstagram\Endpoint;
use Weissheiten\OAuth2\ClientInstagram\Token;
use TYPO3\Party\Domain\Service\PartyService;

class CollectionController extends \TYPO3\Flow\Mvc\Controller\ActionController {

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
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @var \TYPO3\Neos\Domain\Service\UserService
	 * @Flow\Inject
	 */
	protected $userService;

	/**
	 * @Flow\Inject
	 * @var PartyService
	 */
	protected $partyService;

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * @var \Weissheiten\OAuth2\ClientInstagram\Flow\InstagramFlow
	 * @Flow\Inject
	 */
	protected $authenticationFlow;

	/**
	 * @var \Weissheiten\OAuth2\ClientInstagram\Utility\InstagramApiClient
	 * @Flow\Inject
	 */
	protected $instagramApiClient;

	/**
	 * Show a list of InstagramCollections and their properties
	 *
	 * @return void
	 */
	public function indexAction() {

		$instagramCollections = $this->instagramCollectionRepository->findAll();
        $currentUser = $this->userService->getCurrentUser();

        $instagramAccessToken = '';

//         \TYPO3\Flow\var_dump($this->userService->getCurrentUser()->getAccounts());

        /* @var $account \TYPO3\Flow\Security\Account */
        foreach($currentUser->getAccounts() as $account){
            if($account->getAuthenticationProviderName()=='InstagramOAuth2Provider'){
                $instagramAccessToken = $account->getCredentialsSource();
            }
        }

        $this->instagramApiClient->setCurrentAccessToken($instagramAccessToken);
        $ownUserData = $this->instagramApiClient->getOwnUserData();

        $this->view->assignMultiple(array(
			'userData' => $ownUserData,
			'instagramCollections' => $instagramCollections
		));
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