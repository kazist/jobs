<?php

namespace Jobs\Certifications\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Certifications
 *
 * @ORM\Table(name="jobs_certifications")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Certifications extends \Kazist\Table\BaseTable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordering", type="integer", length=11, nullable=false)
     */
    protected $ordering;

    /**
     * @var integer
     *
     * @ORM\Column(name="published", type="integer", length=11, nullable=false)
     */
    protected $published;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", length=11, nullable=false)
     */
    protected $created_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    protected $date_created;

    /**
     * @var integer
     *
     * @ORM\Column(name="modified_by", type="integer", length=11, nullable=false)
     */
    protected $modified_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    protected $date_modified;


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
     * @param string $title
     * @return Certifications
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
     * Set ordering
     *
     * @param integer $ordering
     * @return Certifications
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering
     *
     * @return integer 
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * Set published
     *
     * @param integer $published
     * @return Certifications
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return integer 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Get created_by
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Get date_created
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Get modified_by
     *
     * @return integer 
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * Get date_modified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        // Add your code here
    }
}
