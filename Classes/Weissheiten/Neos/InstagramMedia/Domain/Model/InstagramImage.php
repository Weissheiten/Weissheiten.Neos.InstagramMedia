<?php
namespace Weissheiten\Neos\InstagramMedia\Domain\Model;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class InstagramImage {

    /**
     * @Flow\Validate(type="NotEmpty")
     * @ORM\ManyToOne(inversedBy="instagramImages")
     * @var InstagramCollection
     */
    protected $instagramCollection;

    /**
     * The creation date of this post (set in the constructor)
     *
     * @var \DateTime
     */
    protected $date;

    /**
     * @Flow\Validate(type="NotEmpty")
     * @var string
     */
    protected $uri;

    /**
     * Constructs this InstagramImage
     */
    public function __construct() {
        $this->date = new \DateTime();
    }

    /**
     * @return InstagramCollection
     */
    public function getInstagramCollection() {
        return $this->instagramCollection;
    }

    /**
     * @param InstagramCollection $instagramCollection
     * @return void
     */
    public function setInstagramCollection(InstagramCollection $instagramCollection) {
        $this->instagramCollection = $instagramCollection;
        $this->instagramCollection->addInstagramImage($this);
    }

    /**
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date) {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * @param string
     * @return void
     */
    public function setUri(string $uri) {
        $this->uri = $uri;
    }

}