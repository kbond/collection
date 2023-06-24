<?php

use Doctrine\Persistence\ManagerRegistry;
use Zenstruck\Collection\Doctrine\ORM\Bridge\ORMServiceEntityRepository;

/**
 * @extends ORMServiceEntityRepository<User>
 */
final class UserEntityRepository extends ORMServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}
