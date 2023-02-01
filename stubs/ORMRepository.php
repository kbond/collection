<?php

use Zenstruck\Collection\Doctrine\ORM\EntityRepository;
use Zenstruck\Collection\Doctrine\ORM\Repository\Specification;
use Zenstruck\Collection\Specification\Matchable;

/**
 * @template V of object
 * @extends EntityRepository<V>
 * @implements Matchable<V>
 */
abstract class ORMRepository extends EntityRepository implements Matchable
{
    /** @use Specification<V> */
    use Specification;
}
