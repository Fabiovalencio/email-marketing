<?php
declare(strict_types=1);
namespace CodeEmailMKT\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Customer
{
    private $id;

    private $name;

    private $email;

    /**
     * @var ArrayCollection
     */
    private $tags;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * @return Customer
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Customer
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getTags() : Collection
    {
        return $this->tags;
    }

    public function addTags(Collection $tags)
    {
        /** @var Tag $tag */
        foreach($tags as $tag){
            $tag->getCustomers()->add($this); //adicionando o customer da tag
            $this->tags->add($tag); //adicionadno a tag no meu customer
        }
        return $this;
    }

    public function removeTags(Collection $tags)
    {
        /** @var Tag $tag */
        foreach($tags as $tag){
            $tag->getCustomers()->removeElement($this); //removendo o customer da tag
            $this->tags->removeElement($tag); //removendo a tag no meu customer
        }
        return $this;
    }
}