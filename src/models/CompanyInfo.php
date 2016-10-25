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
    /* @var Int $id Company ID - ICO */
    private $id;
    /* @var string $name Company name */
    private $name;
    /* @var bool $exists */
    private $exists;

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
     * Converts CompanyInfo object to stdClass.
     *
     * @return \stdClass
     */
    public function toPlainStdClass() {
        $r = new \stdClass();
        $r->id = $this->getId();
        $r->name = $this->getName();
        $r->exists = $this->exists();
        return $r;
    }
}
