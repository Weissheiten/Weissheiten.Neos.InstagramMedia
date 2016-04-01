<?php
namespace Weissheiten\Neos\InstagramMedia\Domain\Repository;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;
use TYPO3\Flow\Http\Uri;

use Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection;

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

    /**
     * checks if the Repository contains an image with the given Uri
     *
     * @param Uri $uri uri to search for
     * @return Object
     */
    public function findFirstByShortLinkAndCollection(Uri $uri, InstagramCollection $instagramCollection){
        $query = $this->createQuery();
        $constraints[] = $query->equals('uri', $uri);
        $constraints[] = $query->equals('instagramcollection', $instagramCollection);
        $query->matching($query->logicalAnd($constraints));
        return $query->setLimit(1)->execute()->getFirst();
    }
}
