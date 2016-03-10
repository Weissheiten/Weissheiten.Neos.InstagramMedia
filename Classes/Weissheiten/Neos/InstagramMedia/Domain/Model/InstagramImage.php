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
     * @ORM\ManyToOne(inversedBy="instagramimages")
     * @var InstagramCollection
     */
    protected $instagramcollection;

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
        return $this->instagramcollection;
    }

    /**
     * @param InstagramCollection $instagramCollection
     * @return void
     */
    public function setInstagramCollection(InstagramCollection $instagramcollection) {
        $this->instagramcollection = $instagramcollection;
        $this->instagramcollection->addInstagramImage($this);
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
     * @param string $uri
     * @return void
     */
    public function setUri($uri) {
        $this->uri = $uri;
    }

}