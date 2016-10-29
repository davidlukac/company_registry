<?php

namespace davidlukac\company_registry\models;

/**
 * Class CompanyInfo
 *
 * @package davidlukac\company_registry\models
 */
class CompanyInfo
{
    /** var Int  */
    private $companyId;
    /** var string */
    private $name;
    /** var bool */
    private $exists;
    /** @var string */
    private $address;

    /**
     * @return Int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param Int $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
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
        $result = new \stdClass();
        $result->id = $this->getCompanyId();
        $result->name = $this->getName();
        $result->exists = $this->exists();
        $result->address = $this->getAddress();
        return $result;
    }
}
