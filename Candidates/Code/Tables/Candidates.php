<?php

namespace Jobs\Candidates\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidates
 *
 * @ORM\Table(name="jobs_candidates", indexes={@ORM\Index(name="user_id_index", columns={"user_id"}), @ORM\Index(name="country_id_index", columns={"country_id"}), @ORM\Index(name="location_id_index", columns={"location_id"}), @ORM\Index(name="created_by_index", columns={"created_by"}), @ORM\Index(name="modified_by_index", columns={"modified_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Candidates extends \Kazist\Table\BaseTable
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
     * @ORM\Column(name="user_id", type="integer", length=11, nullable=true)
     */
    protected $user_id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    protected $dob;

    /**
     * @var integer
     *
     * @ORM\Column(name="education", type="integer", length=11, nullable=true)
     */
    protected $education;

    /**
     * @var integer
     *
     * @ORM\Column(name="resume", type="integer", length=11, nullable=true)
     */
    protected $resume;

    /**
     * @var integer
     *
     * @ORM\Column(name="available", type="integer", length=11, nullable=true)
     */
    protected $available;

    /**
     * @var integer
     *
     * @ORM\Column(name="avatar", type="integer", length=11, nullable=true)
     */
    protected $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=false)
     */
    protected $website;

    /**
     * @var integer
     *
     * @ORM\Column(name="country_id", type="integer", length=11, nullable=true)
     */
    protected $country_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_id", type="integer", length=11, nullable=true)
     */
    protected $location_id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="profile", type="text", nullable=true)
     */
    protected $profile;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(name="other_info", type="text", nullable=true)
     */
    protected $other_info;

    /**
     * @var integer
     *
     * @ORM\Column(name="package_id", type="integer", length=11, nullable=true)
     */
    protected $package_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="package_price_id", type="integer", length=11, nullable=true)
     */
    protected $package_price_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="payment_amount", type="integer", length=11, nullable=true)
     */
    protected $payment_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_stage", type="string", length=255, nullable=true)
     */
    protected $payment_stage;

    /**
     * @var integer
     *
     * @ORM\Column(name="payment_status", type="integer", length=11, nullable=true)
     */
    protected $payment_status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_date", type="datetime", nullable=true)
     */
    protected $payment_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_expiry", type="datetime", nullable=true)
     */
    protected $payment_expiry;

    /**
     * @var integer
     *
     * @ORM\Column(name="featured", type="integer", length=11, nullable=true)
     */
    protected $featured;

    /**
     * @var integer
     *
     * @ORM\Column(name="published", type="integer", length=11, nullable=true)
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
     * Set user_id
     *
     * @param integer $userId
     * @return Candidates
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Candidates
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     * @return Candidates
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime 
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set education
     *
     * @param integer $education
     * @return Candidates
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return integer 
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set resume
     *
     * @param integer $resume
     * @return Candidates
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return integer 
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set available
     *
     * @param integer $available
     * @return Candidates
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return integer 
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set avatar
     *
     * @param integer $avatar
     * @return Candidates
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return integer 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Candidates
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Candidates
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Candidates
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set country_id
     *
     * @param integer $countryId
     * @return Candidates
     */
    public function setCountryId($countryId)
    {
        $this->country_id = $countryId;

        return $this;
    }

    /**
     * Get country_id
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * Set location_id
     *
     * @param integer $locationId
     * @return Candidates
     */
    public function setLocationId($locationId)
    {
        $this->location_id = $locationId;

        return $this;
    }

    /**
     * Get location_id
     *
     * @return integer 
     */
    public function getLocationId()
    {
        return $this->location_id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Candidates
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set profile
     *
     * @param string $profile
     * @return Candidates
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return string 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Candidates
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set other_info
     *
     * @param string $otherInfo
     * @return Candidates
     */
    public function setOtherInfo($otherInfo)
    {
        $this->other_info = $otherInfo;

        return $this;
    }

    /**
     * Get other_info
     *
     * @return string 
     */
    public function getOtherInfo()
    {
        return $this->other_info;
    }

    /**
     * Set package_id
     *
     * @param integer $packageId
     * @return Candidates
     */
    public function setPackageId($packageId)
    {
        $this->package_id = $packageId;

        return $this;
    }

    /**
     * Get package_id
     *
     * @return integer 
     */
    public function getPackageId()
    {
        return $this->package_id;
    }

    /**
     * Set package_price_id
     *
     * @param integer $packagePriceId
     * @return Candidates
     */
    public function setPackagePriceId($packagePriceId)
    {
        $this->package_price_id = $packagePriceId;

        return $this;
    }

    /**
     * Get package_price_id
     *
     * @return integer 
     */
    public function getPackagePriceId()
    {
        return $this->package_price_id;
    }

    /**
     * Set payment_amount
     *
     * @param integer $paymentAmount
     * @return Candidates
     */
    public function setPaymentAmount($paymentAmount)
    {
        $this->payment_amount = $paymentAmount;

        return $this;
    }

    /**
     * Get payment_amount
     *
     * @return integer 
     */
    public function getPaymentAmount()
    {
        return $this->payment_amount;
    }

    /**
     * Set payment_stage
     *
     * @param string $paymentStage
     * @return Candidates
     */
    public function setPaymentStage($paymentStage)
    {
        $this->payment_stage = $paymentStage;

        return $this;
    }

    /**
     * Get payment_stage
     *
     * @return string 
     */
    public function getPaymentStage()
    {
        return $this->payment_stage;
    }

    /**
     * Set payment_status
     *
     * @param integer $paymentStatus
     * @return Candidates
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->payment_status = $paymentStatus;

        return $this;
    }

    /**
     * Get payment_status
     *
     * @return integer 
     */
    public function getPaymentStatus()
    {
        return $this->payment_status;
    }

    /**
     * Set payment_date
     *
     * @param \DateTime $paymentDate
     * @return Candidates
     */
    public function setPaymentDate($paymentDate)
    {
        $this->payment_date = $paymentDate;

        return $this;
    }

    /**
     * Get payment_date
     *
     * @return \DateTime 
     */
    public function getPaymentDate()
    {
        return $this->payment_date;
    }

    /**
     * Set payment_expiry
     *
     * @param \DateTime $paymentExpiry
     * @return Candidates
     */
    public function setPaymentExpiry($paymentExpiry)
    {
        $this->payment_expiry = $paymentExpiry;

        return $this;
    }

    /**
     * Get payment_expiry
     *
     * @return \DateTime 
     */
    public function getPaymentExpiry()
    {
        return $this->payment_expiry;
    }

    /**
     * Set featured
     *
     * @param integer $featured
     * @return Candidates
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return integer 
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set published
     *
     * @param integer $published
     * @return Candidates
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
