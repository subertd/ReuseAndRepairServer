<?php
/**
 * Created by PhpStorm.
 * User: Donald
 * Date: 5/4/2015
 * Time: 3:28 PM
 */

namespace ReuseAndRepair\Models;


/**
 * Class Item
 * @package ReuseAndRepair\Models
 *
 * A model of the Item entity
 */
class Item {

    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $categoryRef;

    /** @var Category */
    private $category;

    /** @var array */
    private $organizations = array();

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
     * @return int
     */
    public function getCategoryRef()
    {
        return $this->categoryRef;
    }

    /**
     * @param int $categoryRef
     */
    public function setCategoryRef($categoryRef)
    {
        $this->categoryRef = $categoryRef;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return array
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * @param array $organizations
     */
    public function setOrganizations($organizations)
    {
        $this->organizations = $organizations;
    }
}