<?php

namespace CodeEmailMKT\Infrastructure\Persistence\Doctrine\Repository;

use CodeEmailMKT\Domain\Entity\Customer;
use CodeEmailMKT\Domain\Entity\Tag;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\UnitOfWork;


class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{
    public function create($entity) : Customer
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function update($entity) : Customer
    {
        if($this->getEntityManager()->getUnitOfWork()->getEntityState($entity) != UnitOfWork::STATE_MANAGED){
            $this->getEntityManager()->merge($entity);
        }

        $this->getEntityManager()->flush();
        return $entity;
    }

    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function find($id) : Customer
    {
        return parent::find($id);
    }

    public function findAll() : array
    {
        return parent::findAll();
    }

    public function findByEmail($email) : Customer
    {
        return parent::findBy(array('email' => $email));
    }

    public function findByTags(array $tags) : array
    {
        $qb = $this->createQueryBuilder('c')
            ->distinct()
            ->leftJoin(Tag::class, 't')
            ->andWhere('t.id IN (:tag_ids)')
            ->setParameter('tag_ids', $tags);

        return $qb->getQuery()->getResult();
    }
}