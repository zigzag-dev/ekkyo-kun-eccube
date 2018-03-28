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

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $name_en;

    /**
     * @var boolean
     */
    private $deny;

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
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * Set name
     *
     * @param string $name
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name_en
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * Set name_en
     *
     * @param string $name_en
     * @return Country
     */
    public function setNameEn($name_en)
    {
        $this->name_en = $name_en;

        return $this;
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
