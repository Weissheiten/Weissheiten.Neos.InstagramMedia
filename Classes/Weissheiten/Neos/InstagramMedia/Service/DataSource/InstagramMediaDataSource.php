<?php
namespace Weissheiten\Neos\InstagramMedia\Service\DataSource;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;
use Weissheiten\Neos\InstagramMedia\Exception;
use TYPO3\Neos\Service\DataSource\AbstractDataSource;

class InstagramMediaDataSource{

    /**
     * @var string
     */
    static protected $identifier = 'InstagramMedia';

    /**
     * @Flow\Inject
     * @var \Weissheiten\Neos\InstagramMedia\Service\InstagramQuery
     */
    protected $instagramQuery;

    /**
     * Get analytics stats for the given node
     *
     * {@inheritdoc}
     */
    public function getData(NodeInterface $node = NULL, array $arguments){
        return array(

        );
    }

}
