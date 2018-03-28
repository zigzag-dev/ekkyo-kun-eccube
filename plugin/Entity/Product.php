<?php

namespace Plugin\EkkyoKun\Entity;

/**
 * Product
 */
class Product extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $deny = false;

    /**
     * Set id
     *
     * @param integer $id
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set deny
     *
     * @param boolean $deny
     * @return Product
     */
    public function setDeny($deny)
    {
        $this->deny = $deny;

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
}
