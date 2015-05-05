<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:28 PM
 */

namespace ReuseAndRepair\Models;


/**
 * Class Organization
 * @package ReuseAndRepair\Models
 *
 * A model of the Organization entity
 */
class Organization {

    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var  string */
    private $phoneNumber;

    /** @var  string */
    private $websiteUrl;

    /** @var  string */
    private $physicalAddress;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    }

    /**
     * @return string
     */
    public function getPhysicalAddress()
    {
        return $this->physicalAddress;
    }

    /**
     * @param string $physicalAddress
     */
    public function setPhysicalAddress($physicalAddress)
    {
        $this->physicalAddress = $physicalAddress;
    }
}