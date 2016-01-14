<?php
namespace Weissheiten\Neos\InstagramMedia\Service;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 */
use TYPO3\Flow\Annotations as Flow;
use Weissheiten\Neos\InstagramMedia\Exception\MissingConfigurationException;
use Weissheiten\Neos\InstagramMedia\Service\InstagramAPIConnector;
/**
 * Factory for Instagram API Client
 */

class ClientFactory{
    /**
     * @Flow\Inject
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * @Flow\Inject(setting="authentication", package="Weissheiten.Neos.InstagramMedia")
     * @var array
     */
    protected $authenticationSettings;

    /**
     * @throws MissingConfigurationException
     * @return \Weissheiten\Neos\InstagramMedia\Service\InstagramAPIConnector
     */
    public function create(){
        $requiredAuthenticationSettings = array(
            'clientId',
            'clientSecret'
        );

        foreach($requiredAuthenticationSettings as $key){
            if(!isset($this->authenticationSettings['key'])){
                throw new Weissheiten\Neos\InstagramMedia\Exception\MissingConfigurationException(sprintf('Missing setting "Weissheiten.Neos.InstagramMedia.authentication.%s"', $key), 1452784464);
            }
        }

        $client = new InstagramAPIConnector($this->authenticationSettings['clientId']);



    }



}