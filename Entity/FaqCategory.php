<?php

namespace Btn\FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Btn\BaseBundle\Util\Text;

/**
 * FaqCategory
 *
 * @ORM\Table(name="faq_category", indexes={
 *     @ORM\Index(name="slug_idx", columns={"slug"}),
 *     @ORM\Index(name="visible_idx", columns={"visible", "position"})
 * })
 * @ORM\Entity(repositoryClass="Btn\FaqBundle\Repository\FaqCategoryRepository")
 */
class FaqCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=64, nullable=false)
     * @Assert\Regex(pattern="/^[_\-a-z0-9]+$/")
     * @Assert\NotBlank(message="Slug contains only digits, small letters and chars like '-', '_'")
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="smallint", nullable=false)
     * @Assert\NotBlank(message="Position should be a number")
     */
    private $position;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Btn\FaqBundle\Entity\Faq",
     *     mappedBy="category",
     *     cascade={"persist", "remove"}
     * )
     */
    private $faqs;

    /**
     *
     */
    public function __construct()
    {
        $this->faqs  = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param  string      $title
     * @return FaqCategory
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
     * Set slug
     *
     * @param  string      $slug
     * @return FaqCategory
     */
    public function setSlug($slug)
    {
        $this->slug = Text::slugify($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set visible
     *
     * @param  boolean     $visible
     * @return FaqCategory
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set position
     *
     * @param  integer     $position
     * @return FaqCategory
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add faqs
     *
     * @param  \Btn\FaqBundle\Entity\Faq $faqs
     * @return FaqCategory
     */
    public function addFaq(\Btn\FaqBundle\Entity\Faq $faqs)
    {
        $this->faqs[] = $faqs;

        return $this;
    }

    /**
     * Remove faqs
     *
     * @param \Btn\FaqBundle\Entity\Faq $faqs
     */
    public function removeFaq(\Btn\FaqBundle\Entity\Faq $faqs)
    {
        $this->faqs->removeElement($faqs);
    }

    /**
     * Get faqs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFaqs()
    {
        return $this->faqs;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}
