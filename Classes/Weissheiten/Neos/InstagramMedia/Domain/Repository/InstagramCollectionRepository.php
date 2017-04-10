<?php
namespace Weissheiten\Neos\InstagramMedia\Domain\Repository;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * The InstagramCollection Repository
 *
 * @Flow\Scope("singleton")
 */
class InstagramCollectionRepository extends Repository
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
