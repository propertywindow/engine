<?php declare(strict_types=1);

namespace PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="property")
 * @ORM\Entity(repositoryClass="PropertyBundle\Repository\PropertyRepository")
 */
class Sale
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="sub_area", type="integer", nullable=false)
     */
    private $subArea;

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modified", type="datetime", nullable=false)
     */
    private $lastModified;

    /**
     * @var string
     *
     * @ORM\Column(name="room_sizes", type="text", nullable=true)
     */
    private $roomSizes;

    /**
     * @var string
     *
     * @ORM\Column(name="viewing", type="string", length=200, nullable=true)
     */
    private $viewing;

    /**
     * @var string
     *
     * @ORM\Column(name="features", type="text", nullable=true)
     */
    private $features;

    /**
     * @var bool
     *
     * @ORM\Column(name="garage", type="boolean", nullable=true)
     */
    private $garage;

    /**
     * @var bool
     *
     * @ORM\Column(name="garden", type="boolean", nullable=true)
     */
    private $garden;

    /**
     * @var int
     *
     * @ORM\Column(name="reception_rooms", type="integer", nullable=true)
     */
    private $receptionRooms;

    /**
     * @var string
     *
     * @ORM\Column(name="hip_path", type="string", length=100, nullable=true)
     */
    private $hIPPath;

    /**
     * @var int
     *
     * @ORM\Column(name="image_overlay", type="integer", nullable=true)
     */
    private $imageOverlay;

    /**
     * @var string
     *
     * @ORM\Column(name="podcast_path", type="string", length=150, nullable=true)
     */
    private $podcastPath;

    /**
     * @var string
     *
     * @ORM\Column(name="e_brochure_path", type="string", length=150, nullable=true)
     */
    private $eBrochurePath;

    /**
     * @var string
     *
     * @ORM\Column(name="showroom", type="string", length=255, nullable=true)
     */
    private $showroom;

    /**
     * @var bool
     *
     * @ORM\Column(name="datafeed", type="boolean", nullable=true)
     */
    private $datafeed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="archive_date", type="datetime", nullable=true)
     */
    private $archiveDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime", nullable=true)
     */
    private $updateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="epc", type="string", length=50, nullable=true)
     */
    private $EPC;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10, nullable=true)
     */
    private $postcode;

    /**
     * @var int
     *
     * @ORM\Column(name="terms", type="integer", nullable=false)
     */
    private $terms;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="sub_type", type="integer", nullable=false)
     */
    private $subType;

    /**
     * @var int
     *
     * @ORM\Column(name="bedrooms", type="integer", nullable=true)
     */
    private $bedrooms;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="blob", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=100, nullable=true)
     */
    private $imagePath;

    /**
     * @var string
     *
     * @ORM\Column(name="schedule_path", type="string", length=100, nullable=true)
     */
    private $schedulePath;

    /**
     * @var string
     *
     * @ORM\Column(name="floorplan_path", type="string", length=100, nullable=true)
     */
    private $floorplanPath;

    /**
     * @var int
     *
     * @ORM\Column(name="agent", type="integer", nullable=true)
     */
    private $agent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addedDate", type="datetime", nullable=true)
     */
    private $addedDate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", options={"default":2})
     */
    private $status;

    /** php bin/console doctrine:schema:update --force
     * @var string
     *
     * @ORM\Column(name="web_print", type="string", length=20, nullable=true)
     */
    private $webPrint;

    /**
     * @var string
     *
     * @ORM\Column(name="tours_path", type="string", length=150, nullable=true)
     */
    private $toursPath;

    /**
     * @var string
     *
     * @ORM\Column(name="espc", type="string", length=10, nullable=true)
     */
    private $eSPC;

    /**
     * @var string
     *
     * @ORM\Column(name="local", type="string", length=15, nullable=true)
     */
    private $local;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entry_date", type="datetime", nullable=true)
     */
    private $entryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closing_date", type="datetime", nullable=true)
     */
    private $closingDate;

    /**
     * @var int
     *
     * @ORM\Column(name="sold_price", type="integer", nullable=true)
     */
    private $soldPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="general_notes", type="integer", nullable=true)
     */
    private $generalNotes;

    /**
     * @var string
     *
     * @ORM\Column(name="espc_info", type="blob", nullable=true)
     */
    private $eSPCInfo;

    /**
     * @var int
     *
     * @ORM\Column(name="seller", type="integer", nullable=true)
     */
    private $seller;

    /**
     * @var string
     *
     * @ORM\Column(name="staff", type="string", length=50, nullable=true)
     */
    private $staff;


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
     * Set subArea
     *
     * @param integer $subArea
     *
     * @return PropertySale
     */
    public function setSubArea($subArea)
    {
        $this->subArea = $subArea;

        return $this;
    }

    /**
     * Get subArea
     *
     * @return int
     */
    public function getSubArea()
    {
        return $this->subArea;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     *
     * @return PropertySale
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return bool
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     *
     * @return PropertySale
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set roomSizes
     *
     * @param string $roomSizes
     *
     * @return PropertySale
     */
    public function setRoomSizes($roomSizes)
    {
        $this->roomSizes = $roomSizes;

        return $this;
    }

    /**
     * Get roomSizes
     *
     * @return string
     */
    public function getRoomSizes()
    {
        return $this->roomSizes;
    }

    /**
     * Set viewing
     *
     * @param string $viewing
     *
     * @return PropertySale
     */
    public function setViewing($viewing)
    {
        $this->viewing = $viewing;

        return $this;
    }

    /**
     * Get viewing
     *
     * @return string
     */
    public function getViewing()
    {
        return $this->viewing;
    }

    /**
     * Set features
     *
     * @param string $features
     *
     * @return PropertySale
     */
    public function setFeatures($features)
    {
        $this->features = $features;

        return $this;
    }

    /**
     * Get features
     *
     * @return string
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set garage
     *
     * @param boolean $garage
     *
     * @return PropertySale
     */
    public function setGarage($garage)
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * Get garage
     *
     * @return bool
     */
    public function getGarage()
    {
        return $this->garage;
    }

    /**
     * Set garden
     *
     * @param boolean $garden
     *
     * @return PropertySale
     */
    public function setGarden($garden)
    {
        $this->garden = $garden;

        return $this;
    }

    /**
     * Get garden
     *
     * @return bool
     */
    public function getGarden()
    {
        return $this->garden;
    }

    /**
     * Set receptionRooms
     *
     * @param integer $receptionRooms
     *
     * @return PropertySale
     */
    public function setReceptionRooms($receptionRooms)
    {
        $this->receptionRooms = $receptionRooms;

        return $this;
    }

    /**
     * Get receptionRooms
     *
     * @return int
     */
    public function getReceptionRooms()
    {
        return $this->receptionRooms;
    }

    /**
     * Set hIPPath
     *
     * @param string $hIPPath
     *
     * @return PropertySale
     */
    public function setHIPPath($hIPPath)
    {
        $this->hIPPath = $hIPPath;

        return $this;
    }

    /**
     * Get hIPPath
     *
     * @return string
     */
    public function getHIPPath()
    {
        return $this->hIPPath;
    }

    /**
     * Set imageOverlay
     *
     * @param integer $imageOverlay
     *
     * @return PropertySale
     */
    public function setImageOverlay($imageOverlay)
    {
        $this->imageOverlay = $imageOverlay;

        return $this;
    }

    /**
     * Get imageOverlay
     *
     * @return int
     */
    public function getImageOverlay()
    {
        return $this->imageOverlay;
    }

    /**
     * Set podcastPath
     *
     * @param string $podcastPath
     *
     * @return PropertySale
     */
    public function setPodcastPath($podcastPath)
    {
        $this->podcastPath = $podcastPath;

        return $this;
    }

    /**
     * Get podcastPath
     *
     * @return string
     */
    public function getPodcastPath()
    {
        return $this->podcastPath;
    }

    /**
     * Set eBrochurePath
     *
     * @param string $eBrochurePath
     *
     * @return PropertySale
     */
    public function setEBrochurePath($eBrochurePath)
    {
        $this->eBrochurePath = $eBrochurePath;

        return $this;
    }

    /**
     * Get eBrochurePath
     *
     * @return string
     */
    public function getEBrochurePath()
    {
        return $this->eBrochurePath;
    }

    /**
     * Set showroom
     *
     * @param string $showroom
     *
     * @return PropertySale
     */
    public function setShowroom($showroom)
    {
        $this->showroom = $showroom;

        return $this;
    }

    /**
     * Get showroom
     *
     * @return string
     */
    public function getShowroom()
    {
        return $this->showroom;
    }

    /**
     * Set datafeed
     *
     * @param boolean $datafeed
     *
     * @return PropertySale
     */
    public function setDatafeed($datafeed)
    {
        $this->datafeed = $datafeed;

        return $this;
    }

    /**
     * Get datafeed
     *
     * @return bool
     */
    public function getDatafeed()
    {
        return $this->datafeed;
    }

    /**
     * Set archiveDate
     *
     * @param \DateTime $archiveDate
     *
     * @return PropertySale
     */
    public function setArchiveDate($archiveDate)
    {
        $this->archiveDate = $archiveDate;

        return $this;
    }

    /**
     * Get archiveDate
     *
     * @return \DateTime
     */
    public function getArchiveDate()
    {
        return $this->archiveDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return PropertySale
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set EPC
     *
     * @param string $EPC
     *
     * @return PropertySale
     */
    public function setEPC($EPC)
    {
        $this->EPC = $EPC;

        return $this;
    }

    /**
     * Get EPC
     *
     * @return string
     */
    public function getEPC()
    {
        return $this->EPC;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return PropertySale
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return PropertySale
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return PropertySale
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
     * Set postcode
     *
     * @param string $postcode
     *
     * @return PropertySale
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set terms
     *
     * @param integer $terms
     *
     * @return PropertySale
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return int
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return PropertySale
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set subType
     *
     * @param integer $subType
     *
     * @return PropertySale
     */
    public function setSubType($subType)
    {
        $this->subType = $subType;

        return $this;
    }

    /**
     * Get subType
     *
     * @return int
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * Set bedrooms
     *
     * @param integer $bedrooms
     *
     * @return PropertySale
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    /**
     * Get bedrooms
     *
     * @return int
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PropertySale
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
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return PropertySale
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set schedulePath
     *
     * @param string $schedulePath
     *
     * @return PropertySale
     */
    public function setSchedulePath($schedulePath)
    {
        $this->schedulePath = $schedulePath;

        return $this;
    }

    /**
     * Get schedulePath
     *
     * @return string
     */
    public function getSchedulePath()
    {
        return $this->schedulePath;
    }

    /**
     * Set floorplanPath
     *
     * @param string $floorplanPath
     *
     * @return PropertySale
     */
    public function setFloorplanPath($floorplanPath)
    {
        $this->floorplanPath = $floorplanPath;

        return $this;
    }

    /**
     * Get floorplanPath
     *
     * @return string
     */
    public function getFloorplanPath()
    {
        return $this->floorplanPath;
    }

    /**
     * Set agent
     *
     * @param integer $agent
     *
     * @return PropertySale
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return int
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set addedDate
     *
     * @param \DateTime $addedDate
     *
     * @return PropertySale
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * Get addedDate
     *
     * @return \DateTime
     */
    public function getAddedDate()
    {
        return $this->addedDate;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return PropertySale
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set webPrint
     *
     * @param string $webPrint
     *
     * @return PropertySale
     */
    public function setWebPrint($webPrint)
    {
        $this->webPrint = $webPrint;

        return $this;
    }

    /**
     * Get webPrint
     *
     * @return string
     */
    public function getWebPrint()
    {
        return $this->webPrint;
    }

    /**
     * Set toursPath
     *
     * @param string $toursPath
     *
     * @return PropertySale
     */
    public function setToursPath($toursPath)
    {
        $this->toursPath = $toursPath;

        return $this;
    }

    /**
     * Get toursPath
     *
     * @return string
     */
    public function getToursPath()
    {
        return $this->toursPath;
    }

    /**
     * Set eSPC
     *
     * @param string $eSPC
     *
     * @return PropertySale
     */
    public function setESPC($eSPC)
    {
        $this->eSPC = $eSPC;

        return $this;
    }

    /**
     * Get eSPC
     *
     * @return string
     */
    public function getESPC()
    {
        return $this->eSPC;
    }

    /**
     * Set local
     *
     * @param string $local
     *
     * @return PropertySale
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return string
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set entryDate
     *
     * @param \DateTime $entryDate
     *
     * @return PropertySale
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    /**
     * Get entryDate
     *
     * @return \DateTime
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * Set closingDate
     *
     * @param \DateTime $closingDate
     *
     * @return PropertySale
     */
    public function setClosingDate($closingDate)
    {
        $this->closingDate = $closingDate;

        return $this;
    }

    /**
     * Get closingDate
     *
     * @return \DateTime
     */
    public function getClosingDate()
    {
        return $this->closingDate;
    }

    /**
     * Set soldPrice
     *
     * @param integer $soldPrice
     *
     * @return PropertySale
     */
    public function setSoldPrice($soldPrice)
    {
        $this->soldPrice = $soldPrice;

        return $this;
    }

    /**
     * Get soldPrice
     *
     * @return int
     */
    public function getSoldPrice()
    {
        return $this->soldPrice;
    }

    /**
     * Set generalNotes
     *
     * @param integer $generalNotes
     *
     * @return PropertySale
     */
    public function setGeneralNotes($generalNotes)
    {
        $this->generalNotes = $generalNotes;

        return $this;
    }

    /**
     * Get generalNotes
     *
     * @return int
     */
    public function getGeneralNotes()
    {
        return $this->generalNotes;
    }

    /**
     * Set eSPCInfo
     *
     * @param string $eSPCInfo
     *
     * @return PropertySale
     */
    public function setESPCInfo($eSPCInfo)
    {
        $this->eSPCInfo = $eSPCInfo;

        return $this;
    }

    /**
     * Get eSPCInfo
     *
     * @return string
     */
    public function getESPCInfo()
    {
        return $this->eSPCInfo;
    }

    /**
     * Set seller
     *
     * @param integer $seller
     *
     * @return PropertySale
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get seller
     *
     * @return int
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Set staff
     *
     * @param string $staff
     *
     * @return PropertySale
     */
    public function setStaff($staff)
    {
        $this->staff = $staff;

        return $this;
    }

    /**
     * Get staff
     *
     * @return string
     */
    public function getStaff()
    {
        return $this->staff;
}
