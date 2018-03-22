<?php

namespace Plugin\EkkyoKun\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $deny = 'false';

    /**
     * @var \Eccube\Entity\Product
     */
    private $Product;


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

    /**
     * Set Product
     *
     * @param \Eccube\Entity\Product $product
     * @return Product
     */
    public function setProduct(\Eccube\Entity\Product $product)
    {
        $this->Product = $product;

        return $this;
    }

    /**
     * Get Product
     *
     * @return \Eccube\Entity\Product 
     */
    public function getProduct()
    {
        return $this->Product;
    }
}
