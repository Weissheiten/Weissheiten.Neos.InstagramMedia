<?php
namespace Weissheiten\Neos\InstagramMedia\Service;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class InstagramClient
{
    protected $clientId;

    protected $clientSecret;

    protected $accessToken;

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
     * @return string
     */
    public function isTokenSet(){
        return ($this->accessToken!==NULL) ? $this->accessToken : 'No access token available';
    }
}