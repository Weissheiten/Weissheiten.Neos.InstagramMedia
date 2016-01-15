<?php
namespace Weissheiten\Neos\InstagramMedia\Service;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;
use Weissheiten\Neos\InstagramMedia\Exception;

/**
 * Instagram API service
 *
 * @Flow\Scope("singleton")
 */
class InstagramService{

    /**
     * @param InstagramClient $instagramClient
     */
    protected $instagramClient;

    /*
	 * Create a new Instagram Service
	 *
	 * @param InstagramClient $instagramClient
	 * @return void
	 */
    public function __construct($instagramClient)
    {
        $this->instagramClient = $instagramClient;
    }

   /**
    * @return InstagramClient
    */
    public function getInstagramClient(){
        return $this->instagramClient;
    }

    /**
     * Require an authenticated Instagram service
     *
     * @return InstagramClient The current instance for chaining
     * @throws \Weissheiten\Neos\InstagramMedia\Exception\AuthenticationRequiredException
     */
    public function requireAuthentication(){
        if((string)$this->accessToken === ''){
            throw new MissingConfigurationException('No access token',1452784480);
        }
        return this;
    }
}