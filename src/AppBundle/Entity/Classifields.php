<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Classifields
 *
 * @ORM\Table(name="classifields")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClassifieldsRepository")
 */
class Classifields
{
    const STATUS_ACTIVE = "active";
    const STATUS_FINISHED = "finished";
    const STATUS_CANCELLED = "cancelled";
    const CATEGORY_SELL = "sprzedam";
    const CATEGORY_BUY = "kupie";
    const CATEGORY_CHANGE = "zamienie";


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(
     *     message="Tytuł nie może być pusty."
     * )
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Tytuł nie może być krótszy niż 3 znaki",
     *     maxMessage="Tytuł nie może być dłuższy niż 255 znaków"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(
     *     message="Opis nie może być pusty."
     * )
     * @Assert\Length(
     *     min=10,
     *     minMessage="Opis nie może być krótszy niż 10 znaków"
     * )
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(message="E-mail nie może być pusty.")
     * @Assert\Email(message="Wartośc nie jest adresem e-mail")
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="indicator", type="string", length=255)
     */
    private $indicator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime")
     */
    private $expiresAt;

    /**
     * @var float
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *     message="Cena nie może być pusta."
     * )
     * @Assert\GreaterThan(
     *     value="0",
     *     message="Cena musi być większa od 0"
     * )
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @Assert\Image(mimeTypes = {"image/png", "image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Tylko rozszerzenie png, jpg. jpeg",
     *     minWidth="150",
     *     minWidthMessage="Minimalny dopuszczalny rozmiar szerokości zdjęcia to 150px.",
     *     maxWidth="1000",
     *     maxWidthMessage="Maksymalny dopuszczalny rozmiar szerokości zdjęcia to 1000px.",
     *     minHeight="150",
     *     minHeightMessage="Minimalny dopuszczalny rozmiar wysokości zdjęcia to 150px.",
     *     maxHeight="1000",
     *     maxHeightMessage="Maksymalny dopuszczalny rozmiar wysokości zdjęcia to 1000px.")
     * @ORM\Column(name="image",type="string", nullable=true)
     */
    private $image;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="classifields")
     */
    private $owner;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Classifields
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Classifields
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Classifields
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set indicator
     *
     * @param string $indicator
     *
     * @return Classifields
     */
    public function setIndicator($indicator)
    {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return string
     */
    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     *
     * @return $this
     */
    public function setExpiresAt(\DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Classifields
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param User $owner
     * @return $this
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

}

