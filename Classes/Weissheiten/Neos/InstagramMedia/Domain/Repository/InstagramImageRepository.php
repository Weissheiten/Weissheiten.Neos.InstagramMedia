<?php
namespace Weissheiten\Neos\InstagramMedia\Domain\Repository;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * The InstagramImage Repository
 *
 * @Flow\Scope("singleton")
 */
class InstagramImageRepository extends Repository
{
    /**
     * Finds the first collection
     *
     * @return \Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection The first collection or NULL if none exists
     */
    public function findFirst()
    {
        return $this->createQuery()->execute()->getFirst();
    }
}
