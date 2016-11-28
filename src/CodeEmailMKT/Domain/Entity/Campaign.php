<?php
declare(strict_types=1);
namespace CodeEmailMKT\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Campaign
{
    private $id;

    private $name;

    private $subject;

    private $template;

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
     * @return Campaign
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return Campaign
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     * @return Campaign
     */
    public function setTemplate($template)
    {
        $this->template = $template;
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
            $tag->getCampaigns()->add($this); //adicionando a campanha da tag
            $this->tags->add($tag); //adicionadno a tag na minha campanha
        }
        return $this;
    }

    public function removeTags(Collection $tags)
    {
        /** @var Tag $tag */
        foreach($tags as $tag){
            $tag->getCampaigns()->removeElement($this); //removendo a campanha da tag
            $this->tags->removeElement($tag); //removendo a tag na minha campanha
        }
        return $this;
    }
}