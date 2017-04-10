<?php
namespace Weissheiten\Neos\InstagramMedia\Controller;
/*                                                                                  *
 * This script belongs to the TYPO3 Flow package "Weissheiten.Neos.InstagramMedia"  *
 *                                                                                  *
 *                                                                                  */

use Flowpack\OAuth2\Client\Exception;
use Neos\Flow\Annotations as Flow;
use Neos\Error\Messages\Message;
use Neos\Flow\Mvc\ActionRequest;
use Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection;
use Weissheiten\OAuth2\ClientInstagram\Endpoint;
use Weissheiten\OAuth2\ClientInstagram\Token;
use Neos\Party\Domain\Service\PartyService;

class LoginController extends \Neos\Flow\Mvc\Controller\ActionController
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
