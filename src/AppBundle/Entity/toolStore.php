<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * toolStore
 *
 * @ORM\Table(name="tool_store")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\toolStoreRepository")
 */
class toolStore
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
     * @ORM\OneToOne(targetEntity="toolTypes")
     * @ORM\JoinColumn(name="toolId", referencedColumnName="id")
     */
    private $toolId;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;


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
     * Set toolId
     *
     * @param integer $toolId
     *
     * @return toolStore
     */
    public function setToolId($toolId)
    {
        $this->toolId = $toolId;

        return $this;
    }

    /**
     * Get toolId
     *
     * @return int
     */
    public function getToolId()
    {
        return $this->toolId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return toolStore
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
