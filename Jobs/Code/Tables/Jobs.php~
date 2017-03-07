<?php

namespace Jobs\Jobs\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs_jobs", indexes={@ORM\Index(name="category_id_index", columns={"category_id"}), @ORM\Index(name="country_id_index", columns={"country_id"}), @ORM\Index(name="location_id_index", columns={"location_id"}), @ORM\Index(name="package_id_index", columns={"package_id"}), @ORM\Index(name="package_price_id_index", columns={"package_price_id"}), @ORM\Index(name="created_by_index", columns={"created_by"}), @ORM\Index(name="modified_by_index", columns={"modified_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Jobs extends \Kazist\Table\BaseTable
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="image", type="integer", length=11, nullable=true)
     */
    protected $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", length=11, nullable=true)
     */
    protected $category_id;

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
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    protected $website;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    protected $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    protected $longitude;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    protected $start_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    protected $end_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="opening_date", type="datetime", nullable=true)
     */
    protected $opening_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closing_date", type="datetime", nullable=true)
     */
    protected $closing_date;

    /**
     * @var integer
     *
     * @ORM\Column(name="hit", type="integer", length=11, nullable=true)
     */
    protected $hit;

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
     * @ORM\Column(name="payment_expiry", type="datetime", nullable=true)
     */
    protected $payment_expiry;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_date", type="datetime", nullable=true)
     */
    protected $payment_date;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", length=11, nullable=true)
     */
    protected $created_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    protected $date_created;

    /**
     * @var integer
     *
     * @ORM\Column(name="modified_by", type="integer", length=11, nullable=true)
     */
    protected $modified_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
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
     * @return Jobs
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
     * @return Jobs
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
     * Set image
     *
     * @param integer $image
     * @return Jobs
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return integer 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Jobs
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set country_id
     *
     * @param integer $countryId
     * @return Jobs
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
     * @return Jobs
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
     * @return Jobs
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
     * Set email
     *
     * @param string $email
     * @return Jobs
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
     * Set phone
     *
     * @param string $phone
     * @return Jobs
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
     * Set website
     *
     * @param string $website
     * @return Jobs
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
     * Set address
     *
     * @param string $address
     * @return Jobs
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Jobs
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Jobs
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set start_date
     *
     * @param \DateTime $startDate
     * @return Jobs
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $endDate
     * @return Jobs
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set opening_date
     *
     * @param \DateTime $openingDate
     * @return Jobs
     */
    public function setOpeningDate($openingDate)
    {
        $this->opening_date = $openingDate;

        return $this;
    }

    /**
     * Get opening_date
     *
     * @return \DateTime 
     */
    public function getOpeningDate()
    {
        return $this->opening_date;
    }

    /**
     * Set closing_date
     *
     * @param \DateTime $closingDate
     * @return Jobs
     */
    public function setClosingDate($closingDate)
    {
        $this->closing_date = $closingDate;

        return $this;
    }

    /**
     * Get closing_date
     *
     * @return \DateTime 
     */
    public function getClosingDate()
    {
        return $this->closing_date;
    }

    /**
     * Set hit
     *
     * @param integer $hit
     * @return Jobs
     */
    public function setHit($hit)
    {
        $this->hit = $hit;

        return $this;
    }

    /**
     * Get hit
     *
     * @return integer 
     */
    public function getHit()
    {
        return $this->hit;
    }

    /**
     * Set featured
     *
     * @param integer $featured
     * @return Jobs
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
     * @return Jobs
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
     * Set package_id
     *
     * @param integer $packageId
     * @return Jobs
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
     * @return Jobs
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
     * @return Jobs
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
     * @return Jobs
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
     * @return Jobs
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
     * Set payment_expiry
     *
     * @param \DateTime $paymentExpiry
     * @return Jobs
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
     * Set payment_date
     *
     * @param \DateTime $paymentDate
     * @return Jobs
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
