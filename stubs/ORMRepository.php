<?php

use Zenstruck\Collection\Doctrine\ORM\EntityRepository;

/**
 * @template V of object
 * @extends EntityRepository<V>
 */
abstract class ORMRepository extends EntityRepository
{
}
