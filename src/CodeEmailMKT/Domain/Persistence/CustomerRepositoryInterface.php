<?php

namespace CodeEmailMKT\Domain\Persistence;

interface CustomerRepositoryInterface extends RepositoryInterface
{
    public function findByTags(array $tags) : array;
}