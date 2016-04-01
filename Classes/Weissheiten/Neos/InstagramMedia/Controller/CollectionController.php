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
use TYPO3\Flow\Http\Uri;

use Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection;
use Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramImage;
use Weissheiten\OAuth2\ClientInstagram\Endpoint;
use Weissheiten\OAuth2\ClientInstagram\Token;

use TYPO3\Party\Domain\Service\PartyService;

class CollectionController extends \TYPO3\Neos\Controller\Module\AbstractModuleController {

	/**
	 * @Flow\Inject
	 * @var \Weissheiten\Neos\InstagramMedia\Domain\Repository\InstagramCollectionRepository
	 */
	protected $instagramCollectionRepository;

    /**
     * @Flow\Inject
     * @var \Weissheiten\Neos\InstagramMedia\Domain\Repository\InstagramImageRepository
     */
    protected $instagramImageRepository;

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
     * @var array
     */
    protected $viewFormatToObjectNameMap = array(
        'html' => 'TYPO3\Fluid\View\TemplateView',
        'json' => 'TYPO3\Flow\Mvc\View\JsonView'
    );

    /**
	 * Show a list of InstagramCollections and their properties
     *
     * @param string $searchTerm
     * @param InstagramCollection $listInstagramCollectionImages
	 * @return void
	 */
	public function indexAction($searchTerm = null, InstagramCollection $listInstagramCollectionImages = null) {
        $instagramCollections = $this->instagramCollectionRepository->findAll();

        $userData = $this->authenticationFlow->getUserData();

        $instagramSearchResult = ($searchTerm!==null) ? $this->instagramApiClient->searchByTag($searchTerm,20) : null;

        $instagramCollectionImageList = ($listInstagramCollectionImages!==null) ? $listInstagramCollectionImages->getInstagramImages() : null;

        $this->view->assignMultiple(array(
            'argumentNamespace' => $this->request->getArgumentNamespace(),
            'userData' => $userData,
			'instagramCollections' => $instagramCollections,
            'instagramSearchResult' => $instagramSearchResult,
            'instagramCollectionImageList' => $instagramCollectionImageList,
            'settings' => $this->settings
		));

	}


	/**
	 * Adds an InstagramImage to a Collection
	 *
	 * @param InstagramImage $instagramimage
	 * @param InstagramCollection $instagramcollection
     * @return boolean
     *
	 */
	public function addInstagramImageToCollectionAction(InstagramImage $instagramimage, InstagramCollection $instagramcollection){
		$success = false;
        if($instagramcollection->addInstagramImage($instagramimage)){
            $this->persistenceManager->update($instagramcollection);
            $success = true;
        }

		$this->view->assign('value', $success);
	}

    /**
     * @param InstagramCollection $instagramCollection
     * @param Uri $shortLink
     * @param string $username
	 * @return boolean
     */
    public function createInstagramImageAndAddToCollectionAction(InstagramCollection $instagramCollection, Uri $shortLink, $username){
        $success = false;
        /* @var InstagramImage $existingImage */
        $existingImage = $this->instagramImageRepository->findFirstByShortLinkAndCollection($shortLink, $instagramCollection);

        // if the image does already exist and is assigned to a collection do nothing
        if($existingImage===null){
            try{
                $instagramImage = new InstagramImage();
                $instagramImage->setUri($shortLink);
                $instagramImage->setUsername($username);
                $instagramImage->setInstagramCollection($instagramCollection);

                $this->instagramImageRepository->add($instagramImage);
                $this->persistenceManager->persistAll();
                $success = true;
            }
            catch(Exception $e){
                // TODO: log the exception here
                $success = false;
            }
        }
        $this->view->assign('value', $success);

    }

	/**
	 * Create a new InstagramCollection
	 *
	 * @param InstagramCollection $instagramCollection
	 * @return void
	 */
	public function createInstagramCollectionAction(InstagramCollection $instagramCollection){
        if($this->persistenceManager->isNewObject($instagramCollection)){
			$this->instagramCollectionRepository->add($instagramCollection);
		}
		$this->addFlashMessage(sprintf('InstagramCollection "%s" has been added.', htmlspecialchars($instagramCollection->getTitle())));
		$this->redirect('index', null, null, array(), 0, 201);
	}

    /**
     * Edit the given Instagram Collection
     *
     * @param InstagramCollection $instagramCollection
     * @return void
     *
     */
    public function editInstagramCollectionAction(InstagramCollection $instagramCollection){
		$userData = $this->authenticationFlow->getUserData();
		$this->view->assignMultiple(array(
			'userData' => $userData,
			'instagramCollection' => $instagramCollection
		));
    }

    /**
     * Update the given Instagram Collection
     *
     * @param InstagramCollection $instagramCollection
     * @return void
     */
    public function updateInstagramCollectionAction(InstagramCollection $instagramCollection){
        $this->instagramCollectionRepository->update($instagramCollection);
        $this->addFlashMessage('The Instagram Collection "%s" has been updated.', 'User updated', Message::SEVERITY_OK, array($instagramCollection->getTitle()), 1412374498);
        $this->redirect('index');
    }

    /**
     * Delete an InstagramCollection
     *
     * @param InstagramCollection $instagramCollection
     * @return void
     *
     */
    public function deleteInstagramCollectionAction(InstagramCollection $instagramCollection){
        $this->instagramCollectionRepository->remove($instagramCollection);
        /*
        $this->addFlashMessage(sprintf('Collection "%s" has been deleted.', htmlspecialchars($instagramCollection->getTitle())));
        */
        $this->redirect('index');
    }

}