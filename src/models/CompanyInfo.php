<?php
/**
 * Created by PhpStorm.
 * User: davidlukac
 * Date: 16/10/16
 * Time: 12:42
 */

namespace davidlukac\company_registry\models;

/**
 * Class CompanyInfo
 *
 * @package davidlukac\company_registry\models
 */
class CompanyInfo
{
    /** var Int  */
    private $id;
    /** var string */
    private $name;
    /** var bool */
    private $exists;
    /** @var string */
    private $address;

    /**
     * @return Int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Int $id
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
     * @return mixed
     */
    public function exists()
    {
        return $this->exists;
    }

    /**
     * @param mixed $exists
     */
    public function setExists($exists)
    {
        $this->exists = $exists;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }


    /**
     * Converts CompanyInfo object to stdClass.
     *
     * @return \stdClass
     */
    public function toPlainStdClass()
    {
        $r = new \stdClass();
        $r->id = $this->getId();
        $r->name = $this->getName();
        $r->exists = $this->exists();
        $r->address = $this->getAddress();
        return $r;
    }
}
