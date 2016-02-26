<?php
namespace Weissheiten\Neos\InstagramMedia\Controller;
/*                                                                                  *
 * This script belongs to the TYPO3 Flow package "Weissheiten.Neos.InstagramMedia"  *
 *                                                                                  *
 *                                                                                  */

use Flowpack\OAuth2\Client\Exception;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Mvc\ActionRequest;
use Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection;
use Weissheiten\OAuth2\ClientInstagram\Endpoint;
use Weissheiten\OAuth2\ClientInstagram\Token;
use TYPO3\Party\Domain\Service\PartyService;

class LoginController extends \TYPO3\Flow\Mvc\Controller\ActionController
{
    /**
     * Show the login form
     *
     * @return void
     */
    public function loginAction() {
        $this->view->assignMultiple(array(
            'demo' => 'demo'
        ));
    }
}
