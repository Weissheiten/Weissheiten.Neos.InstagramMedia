<?php
namespace Weissheiten\Neos\InstagramMedia\Service;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class TokenStorage {
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Cache\Frontend\StringFrontend
     */
    protected $cache;
    /**
     * @param string $accessToken
     * @return void
     */
    public function storeAccessToken($accessToken) {
        $this->cache->set('AccessToken', $accessToken);
    }

    /**
     * @return string
     */
    public function getAccessToken() {
        $accessToken = $this->cache->get('AccessToken');
        if ($accessToken === FALSE) {
            return NULL;
        }
        return $accessToken;
    }

    /**
     * Remove existing tokens
     *
     * @return void
     */
    public function removeToken() {
        $this->cache->remove('AccessToken');
    }
}