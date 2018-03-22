<?php

namespace Plugin\EkkyoKun\Entity;

/**
 * Country
 */
class Country extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $id;
    private $code;
    private $name;
    private $name_en;

    /**
     * @var boolean
     */
    private $deny;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * @param mixed $name_en
     */
    public function setNameEn($name_en)
    {
        $this->name_en = $name_en;
    }

    /**
     * Get deny
     *
     * @return boolean
     */
    public function getDeny()
    {
        return $this->deny;
    }

    /**
     * Set deny
     *
     * @param boolean $deny
     * @return Country
     */
    public function setDeny($deny)
    {
        $this->deny = $deny;

        return $this;
    }
}
