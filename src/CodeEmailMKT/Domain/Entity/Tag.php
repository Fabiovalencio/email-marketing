<?php
declare(strict_types=1);
namespace CodeEmailMKT\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Tag
{
    private $id;

    private $name;

    private $customers;

    private $campaigns;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->campaigns = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
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
     * @return Tag
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getCustomers() : Collection
    {
        return $this->customers;
    }

    public function getCampaigns() : Collection
    {
        return $this->campaigns;
    }
}