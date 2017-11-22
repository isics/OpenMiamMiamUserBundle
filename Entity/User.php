<?php

namespace Isics\Bundle\OpenMiamMiamUserBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Isics\Bundle\OpenMiamMiamBundle\Entity\Association;
use Isics\Bundle\OpenMiamMiamBundle\Entity\Branch;
use Isics\Bundle\OpenMiamMiamBundle\Entity\Subscription;
use Isics\Bundle\OpenMiamMiamBundle\Model\Location;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity(repositoryClass="Isics\Bundle\OpenMiamMiamUserBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=128, nullable=false)
     * @Expose
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=128, nullable=false)
     * @Expose
     */
    private $lastname;

    /**
     * @var string $address1
     *
     * @ORM\Column(name="address1", type="string", length=64, nullable=true)
     * @Expose
     */
    private $address1;

    /**
     * @var string $address2
     *
     * @ORM\Column(name="address2", type="string", length=64, nullable=true)
     * @Expose
     */
    private $address2;

    /**
     * @var string $zipcode
     *
     * @ORM\Column(name="zipcode", type="string", length=8, nullable=true)
     * @Expose
     */
    private $zipcode;

    /**
     * @var string $city
     *
     * @ORM\Column(name="city", type="string", length=64, nullable=true)
     * @Expose
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $locationStatus;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @var float
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @var float
     */
    private $longitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @var float
     */
    private $sinRadLatitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @var float
     */
    private $cosRadLatitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @var float
     */
    private $radLongitude;

    /**
     * @var string $phoneNumber
     *
     * @ORM\Column(name="phone_number", type="string", length=16, nullable=true)
     * @Expose
     */
    private $phoneNumber;

    /**
     * @var \Doctrine\Common\Collections\Collection $salesOrders
     *
     * @ORM\OneToMany(targetEntity="Isics\Bundle\OpenMiamMiamBundle\Entity\SalesOrder", mappedBy="user")
     */
    private $salesOrders;

    /**
     * @var Collection|Subscription[] $subscriptions
     *
     * @ORM\OneToMany(targetEntity="Isics\Bundle\OpenMiamMiamBundle\Entity\Subscription", mappedBy="user")
     */
    private $subscriptions;

    /**
     * @var boolean $isOrdersOpenNotificationSubscriber
     *
     * @ORM\Column(name="is_orders_open_notification_subscriber", type="boolean", nullable=false, options={"default":0})
     * @Expose
     */
    private $isOrdersOpenNotificationSubscriber;

    /**
     * @var boolean $isNewsletterSubscriber
     *
     * @ORM\Column(name="is_newsletter_subscriber", type="boolean", nullable=false, options={"default":0})
     * @Expose
     */
    private $isNewsletterSubscriber;

    /**
     * @var \Doctrine\Common\Collections\Collection $payments
     *
     * @ORM\OneToMany(targetEntity="Isics\Bundle\OpenMiamMiamBundle\Entity\Payment", mappedBy="user")
     */
    private $payments;

    /**
     * @var \Doctrine\Common\Collections\Collection $activityLogs
     *
     * @ORM\OneToMany(targetEntity="Isics\Bundle\OpenMiamMiamBundle\Entity\Activity", mappedBy="user")
     */
    private $activityLogs;

    /**
     * @var \Doctrine\Common\Collections\Collection $comments
     *
     * @ORM\OneToMany(targetEntity="Isics\Bundle\OpenMiamMiamBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection $writtenComments
     *
     * @ORM\OneToMany(targetEntity="Isics\Bundle\OpenMiamMiamBundle\Entity\Comment", mappedBy="writer")
     */
    private $writtenComments;

    /**
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $facebookId;

    /**
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $facebookAccessToken;

    /**
     * @ORM\Column(name="facebook_refresh_token", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $facebookRefreshToken;

    /**
     * @var Branch
     *
     * @ORM\ManyToOne(targetEntity="Isics\Bundle\OpenMiamMiamBundle\Entity\Branch")
     * @ORM\JoinColumn(nullable=true)
     */
    private $defaultBranch;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastRelaunchAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->isOrdersOpenNotificationSubscriber = false;
        $this->isNewsletterSubscriber             = false;
        $this->locationStatus                     = Location::STATUS_PENDING;
    }

    /**
     * Sets address line 1
     *
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * Returns address line 1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Sets address line 2
     *
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Returns address line 2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Sets city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Sets firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Returns firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Sets lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Returns lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Sets zip code
     *
     * @param string $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Returns zip code
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * Sets isOrdersOpenNotificationSubscriber
     *
     * @param boolean $isOrdersOpenNotificationSubscriber
     */
    public function setIsOrdersOpenNotificationSubscriber($isOrdersOpenNotificationSubscriber)
    {
        $this->isOrdersOpenNotificationSubscriber = $isOrdersOpenNotificationSubscriber;
    }

    /**
     * Returns isOrdersOpenNotificationSubscriber
     *
     * @return boolean
     */
    public function getIsOrdersOpenNotificationSubscriber()
    {
        return $this->isOrdersOpenNotificationSubscriber;
    }

    /**
     * Sets isNewsletterSubscriber
     *
     * @param boolean $isNewsletterSubscriber
     */
    public function setIsNewsletterSubscriber($isNewsletterSubscriber)
    {
        $this->isNewsletterSubscriber = $isNewsletterSubscriber;
    }

    /**
     * Returns isNewsletterSubscriber
     *
     * @return boolean
     */
    public function getIsNewsletterSubscriber()
    {
        return $this->isNewsletterSubscriber;
    }

    /**
     * Return subscription for association
     *
     * @param Association $association
     *
     * @return Subscription
     */
    public function getSubscriptionForAssociation(Association $association)
    {
        foreach ($this->subscriptions as $subcription) {
            if ($subcription->getAssociation()->getId() == $association->getId()) {
                return $subcription;
            }
        }

        return null;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->username          = $email;
        $this->usernameCanonical = $email;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $salesOrders
     */
    public function setSalesOrders($salesOrders)
    {
        $this->salesOrders = $salesOrders;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSalesOrders()
    {
        return $this->salesOrders;
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
     * Add salesOrders
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\SalesOrder $salesOrders
     *
     * @return User
     */
    public function addSalesOrder(\Isics\Bundle\OpenMiamMiamBundle\Entity\SalesOrder $salesOrders)
    {
        $this->salesOrders[] = $salesOrders;

        return $this;
    }

    /**
     * Remove salesOrders
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\SalesOrder $salesOrders
     */
    public function removeSalesOrder(\Isics\Bundle\OpenMiamMiamBundle\Entity\SalesOrder $salesOrders)
    {
        $this->salesOrders->removeElement($salesOrders);
    }

    /**
     * Add subscriptions
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Subscription $subscriptions
     *
     * @return User
     */
    public function addSubscription(\Isics\Bundle\OpenMiamMiamBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;

        return $this;
    }

    /**
     * Remove subscriptions
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Subscription $subscriptions
     */
    public function removeSubscription(\Isics\Bundle\OpenMiamMiamBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions->removeElement($subscriptions);
    }

    /**
     * Add payments
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Payment $payments
     *
     * @return User
     */
    public function addPayment(\Isics\Bundle\OpenMiamMiamBundle\Entity\Payment $payments)
    {
        $this->payments[] = $payments;

        return $this;
    }

    /**
     * Remove payments
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Payment $payments
     */
    public function removePayment(\Isics\Bundle\OpenMiamMiamBundle\Entity\Payment $payments)
    {
        $this->payments->removeElement($payments);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * Add activityLogs
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Activity $activityLogs
     *
     * @return User
     */
    public function addActivityLog(\Isics\Bundle\OpenMiamMiamBundle\Entity\Activity $activityLogs)
    {
        $this->activityLogs[] = $activityLogs;

        return $this;
    }

    /**
     * Remove activityLogs
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Activity $activityLogs
     */
    public function removeActivityLog(\Isics\Bundle\OpenMiamMiamBundle\Entity\Activity $activityLogs)
    {
        $this->activityLogs->removeElement($activityLogs);
    }

    /**
     * Get activityLogs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivityLogs()
    {
        return $this->activityLogs;
    }

    /**
     * Add comments
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Comment $comments
     *
     * @return User
     */
    public function addComment(\Isics\Bundle\OpenMiamMiamBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Comment $comments
     */
    public function removeComment(\Isics\Bundle\OpenMiamMiamBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add writtenComments
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Comment $writtenComments
     *
     * @return User
     */
    public function addWrittenComment(\Isics\Bundle\OpenMiamMiamBundle\Entity\Comment $writtenComments)
    {
        $this->writtenComments[] = $writtenComments;

        return $this;
    }

    /**
     * Remove writtenComments
     *
     * @param \Isics\Bundle\OpenMiamMiamBundle\Entity\Comment $writtenComments
     */
    public function removeWrittenComment(\Isics\Bundle\OpenMiamMiamBundle\Entity\Comment $writtenComments)
    {
        $this->writtenComments->removeElement($writtenComments);
    }

    /**
     * Get writtenComments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWrittenComments()
    {
        return $this->writtenComments;
    }

    /**
     * @param string $facebookAccessToken
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;
    }

    /**
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * @param string $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param string $facebookRefreshToken
     */
    public function setFacebookRefreshToken($facebookRefreshToken)
    {
        $this->facebookRefreshToken = $facebookRefreshToken;
    }

    /**
     * @return string
     */
    public function getFacebookRefreshToken()
    {
        return $this->facebookRefreshToken;
    }

    /**
     * @param float $cosRadLatitude
     */
    public function setCosRadLatitude($cosRadLatitude)
    {
        $this->cosRadLatitude = $cosRadLatitude;
    }

    /**
     * @return float
     */
    public function getCosRadLatitude()
    {
        return $this->cosRadLatitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        $this->setSinRadLatitude(sin(deg2rad($latitude)));
        $this->setCosRadLatitude(cos(deg2rad($latitude)));
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        $this->setRadLongitude(deg2rad($longitude));
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $radLongitude
     */
    public function setRadLongitude($radLongitude)
    {
        $this->radLongitude = $radLongitude;
    }

    /**
     * @return float
     */
    public function getRadLongitude()
    {
        return $this->radLongitude;
    }

    /**
     * @param float $sinRadLatitude
     */
    public function setSinRadLatitude($sinRadLatitude)
    {
        $this->sinRadLatitude = $sinRadLatitude;
    }

    /**
     * @return float
     */
    public function getSinRadLatitude()
    {
        return $this->sinRadLatitude;
    }

    /**
     * @param Branch $defaultBranch
     */
    public function setDefaultBranch(Branch $defaultBranch = null)
    {
        $this->defaultBranch = $defaultBranch;
    }

    /**
     * @return Branch
     */
    public function getDefaultBranch()
    {
        return $this->defaultBranch;
    }

    /**
     * @param \DateTime $lastRelaunchAt
     */
    public function setLastRelaunchAt(\DateTime $lastRelaunchAt = null)
    {
        $this->lastRelaunchAt = $lastRelaunchAt;
    }

    /**
     * @return \DateTime
     */
    public function getLastRelaunchAt()
    {
        return $this->lastRelaunchAt;
    }

    /**
     * @param int $locationStatus
     */
    public function setLocationStatus($locationStatus)
    {
        $this->locationStatus = $locationStatus;
    }

    /**
     * @return int
     */
    public function getLocationStatus()
    {
        return $this->locationStatus;
    }
}
