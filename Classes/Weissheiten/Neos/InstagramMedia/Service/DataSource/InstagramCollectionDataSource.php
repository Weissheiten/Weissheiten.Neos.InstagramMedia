<?php
namespace Weissheiten\Neos\InstagramMedia\Service\DataSource;

/*                                                                                  *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".        *
 *                                                                                  *
 * Provides a DataSource to be used in the backend by according users               *
 * e.g.:                                                                            *
 * properties:                                                                      *
 *   flavorImageCollection:                                                         *
 *     type: 'Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection'     *
 *     ui:                                                                          *
 *       label: 'Instagram Collection'                                              *
 *       inspector:                                                                 *
 *         group: 'flavor'                                                          *
 *         editor: 'Neos.Neos/Inspector/Editors/SelectBoxEditor'                   *
 *         editorOptions:                                                           *
 *           dataSourceIdentifier: 'weissheiten-neos-instagrammedia-collections'    *
 *                                                                                  */

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use \Neos\Flow\Persistence\PersistenceManagerInterface;
use Weissheiten\Neos\InstagramMedia\Domain\Repository\InstagramCollectionRepository;

class InstagramCollectionDataSource extends AbstractDataSource{

    /**
     * @Flow\Inject
     * @var InstagramCollectionRepository
     */
    protected $instagramCollectionRepository;

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @var string
     */
    static protected $identifier = 'weissheiten-neos-instagrammedia-collections';

    /**
     * Get data
     *
     * @param NodeInterface $node The node that is currently edited (optional)
     * @param array $arguments Additional arguments (key / value)
     * @return array JSON serializable data
     */
    public function getData(NodeInterface $node = NULL, array $arguments)
    {
        $collections = $this->instagramCollectionRepository->findAll();

        /* @var \Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection $col */
        foreach($collections as $col) {
            /*$rv[] = array('value' => json_encode(array('__identity' => $this->persistenceManager->getIdentifierByObject($col),
                                            '__type' => '\Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection')),*/
            $rv[] = array('value' => $this->persistenceManager->getIdentifierByObject($col),
                            'label' => $col->getTitle());
        }
        return $rv;
    }



}