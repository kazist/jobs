<?php

namespace Jobs\Candidates\Skills\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skills
 *
 * @ORM\Table(name="jobs_candidates_skills", indexes={@ORM\Index(name="candidate_id_index", columns={"candidate_id"}), @ORM\Index(name="skill_id_index", columns={"skill_id"}), @ORM\Index(name="created_by_index", columns={"created_by"}), @ORM\Index(name="modified_by_index", columns={"modified_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Skills extends \Kazist\Table\BaseTable
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
     * @var integer
     *
     * @ORM\Column(name="candidate_id", type="integer", length=11, nullable=false)
     */
    protected $candidate_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="skill_id", type="integer", length=11, nullable=false)
     */
    protected $skill_id;

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
     * Set candidate_id
     *
     * @param integer $candidateId
     * @return Skills
     */
    public function setCandidateId($candidateId)
    {
        $this->candidate_id = $candidateId;

        return $this;
    }

    /**
     * Get candidate_id
     *
     * @return integer 
     */
    public function getCandidateId()
    {
        return $this->candidate_id;
    }

    /**
     * Set skill_id
     *
     * @param integer $skillId
     * @return Skills
     */
    public function setSkillId($skillId)
    {
        $this->skill_id = $skillId;

        return $this;
    }

    /**
     * Get skill_id
     *
     * @return integer 
     */
    public function getSkillId()
    {
        return $this->skill_id;
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
