<?php
namespace Weissheiten\Neos\InstagramMedia\Domain\Model;

/*                                                                              *
 * This script belongs to the Neos Plugin "Weissheiten.Neos.Instagrammedia".    *
 *                                                                              *
 *                                                                              */
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A collection of Instagram Images
 *
 * @Flow\Entity
 */
class InstagramCollection {

    /**
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Validate(type="StringLength", options={ "minimum"=3, "maximum"=80 })
     * @ORM\Column(length=80)
     * @var string
     */
    protected $title;

    /**
     * @Flow\Validate(type="StringLength", options={ "maximum"=150 })
     * @ORM\Column(length=150)
     * @var string
     */
    protected $description = '';

    /**
     * The InstagramImages contained in this blog
     *
     * @ORM\OneToMany(mappedBy="instagramcollection", orphanRemoval=true)
     * @ORM\OrderBy({"date" = "DESC"})
     * @var Collection<InstagramImage>
     */
    protected $instagramimages;

    /**
     * @param string $title
     */
    public function __construct($title, $description = "") {
        $this->instagramimages = new ArrayCollection();
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return Collection
     */
    public function getInstagramImages() {
        return $this->instagramimages;
    }

    /**
     * Adds a Instagram Image to this collection
     *
     * @param InstagramImage $instagramImage
     * @return bool
     */
    public function addInstagramImage(InstagramImage $instagramimage) {
        if($this->instagramimages->contains($instagramimage) === false){
            $this->instagramimages->add($instagramimage);
            return true;
        }
        return false;
    }

    /**
     * Removes an Instagram Image from this collection
     *
     * @param InstagramImage $instagramImage
     * @return void
     */
    public function removeInstagramImage(InstagramImage $instagramimage) {
        $this->instagramimages->removeElement($instagramimage);
    }
}