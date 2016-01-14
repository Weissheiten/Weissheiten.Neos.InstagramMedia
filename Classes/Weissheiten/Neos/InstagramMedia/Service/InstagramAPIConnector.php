<?php
namespace Weissheiten\Neos\InstagramMedia\Service;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 */

use TYPO3\Flow\Annotations as Flow;
use Weissheiten\Neos\InstagramMedia\Exception\MissingConfigurationException;


/**
 * @Flow\Scope("singleton")
 */
class InstagramAPIConnector
{
    protected $clientId;

    protected $clientSecret;

    protected $accessToken = '';

    public function InstagramAPIConnector(){
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getClientId(){
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId){
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(){
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret){
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function getAccessToken(){
        return $this->accessToken();
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken){
        $this->accessToken = $accessToken;
    }

    /**
     * Require an authenticated Instagram service
     *
     * @return InstagramAPIConnector The current instance for chaining
     * @throws \Weissheiten\Neos\InstagramMedia\Exception\AuthenticationRequiredException
     */
    public function requireAuthentication(){
        if((string)$this->accessToken === ''){
            throw new MissingConfigurationException('No access token',1452784480);
        }
        return this;
    }



}