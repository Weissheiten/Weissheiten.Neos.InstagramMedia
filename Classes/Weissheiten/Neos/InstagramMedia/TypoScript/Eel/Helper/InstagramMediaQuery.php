<?php
namespace Weissheiten\Neos\InstagramMedia\TypoScript\Eel\Helper;
/*                                                            *
 * Custom Eel Helper for Querying the media library.          *
 *                                                            *
 *                                                            */
use TYPO3\Eel\ProtectedContextAwareInterface;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Media\Domain\Model\Tag;
/**
 * Media Query helper for Eel contexts
 */
class InstagramMediaQuery implements ProtectedContextAwareInterface {
    /**
     * @Flow\Inject
     * @var \Weissheiten\Neos\InstagramMedia\Domain\Repository\InstagramCollectionRepository
     */
    protected $instagramRepository;

    /**
     * @param array $configuration Source configuration     *
     * @return mixed
     */
    public function instagramMediaQueryByCollection(array $configuration) {
        if(!isset($configuration[0]) || !is_string($configuration[0])){
            throw new \TYPO3\Eel\EvaluationException('InstagramMediaQuery first parameter: needs an string that sets the title of the collection to fetch');
        }

        if(!isset($configuration[1]) || !is_numeric($configuration[1])){
            throw new \TYPO3\Eel\EvaluationException('mediaLibrary second parameter: needs a numeric value that defines the number of objects to fetch from the instagram collection');
        }

        $collectionIdentifier = $configuration[0];
        $limit = $configuration[1];

        /* @var \Weissheiten\Neos\InstagramMedia\Domain\Model\InstagramCollection $collection */
        $collection = $this->instagramRepository->findByIdentifier($collectionIdentifier);

        $flavorImages = [];

        // a collection has been found
        if($collection!==null){
            $flavorImages = $collection->getInstagramImages()->slice(0,$limit);
        }
        return $flavorImages;
    }
    /**
     * All methods are considered safe
     *
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName) {
        return TRUE;
    }
}