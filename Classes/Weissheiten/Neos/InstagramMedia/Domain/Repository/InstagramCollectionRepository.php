<?php
namespace Weissheiten\Neos\InstagramMedia\Domain\Repository;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;

/**
 * The InstagramCollection Repository
 *
 * @Flow\Scope("singleton")
 * @api
 */
class InstagramCollectionRepository extends \TYPO3\Flow\Persistence\Repository
{
    /**
     * Finds the first collection
     *
     * @return \Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection The first collection or NULL if none exists
     * @api
     */
    public function findFirst()
    {
        return $this->createQuery()->execute()->getFirst();
    }
}
