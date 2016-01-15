<?php
namespace Weissheiten\Neos\InstagramMedia\Service;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 */
use TYPO3\Flow\Annotations as Flow;
use Weissheiten\Neos\InstagramMedia\Exception;
use Weissheiten\Neos\InstagramMedia\Service\InstagramClient;
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
     * @return \Weissheiten\Neos\InstagramMedia\Service\InstagramClient
     */
    public function create(){
        $client = new InstagramClient();

        $requiredAuthenticationSettings = array(
            'clientId',
            'clientSecret'
        );

       // \TYPO3\Flow\var_dump($this->authenticationSettings);

        foreach($requiredAuthenticationSettings as $key){
            if(!isset($this->authenticationSettings[$key])){
                throw new \Weissheiten\Neos\InstagramMedia\Exception\MissingConfigurationException(sprintf('Missing setting "Weissheiten.Neos.InstagramMedia.authentication.%s"', $key), 1452784464);
            }
        }

        $client->setClientId($this->authenticationSettings['clientId']);
        $client->setClientSecret($this->authenticationSettings['clientSecret']);

        $accessToken = $this->tokenStorage->getAccessToken();
        if($accessToken !== NULL){
            $client->setAccessToken($accessToken);
        }

        return $client;
    }
}