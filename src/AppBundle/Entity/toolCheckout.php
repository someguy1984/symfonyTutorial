<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * toolCheckout
 *
 * @ORM\Table(name="tool_checkout")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\toolCheckoutRepository")
 */
class toolCheckout
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
     * Tools owned by this user
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * Many Users to one account.
     * @ORM\ManyToOne(targetEntity="users")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
    */
    private $userId;


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
     * @return toolCheckout
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
     * @return toolCheckout
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

    /**
     * Set userId
     *
     * @param string $userId
     *
     * @return toolCheckout
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
