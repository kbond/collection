<?php

namespace Zenstruck\Collection\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Zenstruck\Collection;
use Zenstruck\Collection\Doctrine\ORM\ObjectRepository;
use Zenstruck\Collection\Doctrine\ORM\Repository\AsEntityRepository;
use Zenstruck\Collection\Doctrine\ORM\Repository\AsService;
use Zenstruck\Collection\Doctrine\ORM\Repository\Flushable;
use Zenstruck\Collection\Doctrine\ORM\Repository\IsCollection;
use Zenstruck\Collection\Doctrine\ORM\Repository\IsMatchable;
use Zenstruck\Collection\Doctrine\ORM\Repository\Removable;
use Zenstruck\Collection\Doctrine\ORM\Repository\Writable;
use Zenstruck\Collection\Paginatable;

/**
 * General purpose ORM repository base class.
 *
 * - Countable: `count($repo)` {@see ObjectRepository::count()}
 * - Lazy-iterable: `foreach ($repo as $object)` {@see ObjectRepository::getIterator()}
 * - Instance of {@see \Doctrine\Persistence\ObjectRepository}
 * - Can batch process: `foreach ($repo->batchProcess() as $object)` {@see ObjectRepository::batchProcess()}
 * - Can "flush": `$repo->flush()` {@see Flushable::flush()}
 * - Can add objects: `$repo->add($object)` {@see Writable::add()}
 * - Can remove objects: `$repo->remove($object)` {@see Removable::remove()}
 *
 * @see AsEntityRepository to add traditional `EntityManager` methods (ie `$repo->findOneBy*()/$repo->findBy*()/$repo->createQueryBuilder()`)
 * @see AsService and implement {@see ServiceEntityRepositoryInterface} to autowire with Symfony (removes need to implement {@see ObjectRepository::em()})
 * @see IsMatchable to use the specification system
 * @see IsCollection to implement {@see Collection}
 * @see Paginatable to make paginatable (requires {@see IsCollection}/{@see Collection})
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 * @extends ObjectRepository<V>
 */
abstract class ORMRepository extends ObjectRepository
{
    /**
     * @use Removable<V>
     * @use Writable<V>
     */
    use Flushable, Removable, Writable;

    /**
     * @return ORMResult<V>
     */
    protected static function createResult(QueryBuilder $qb, bool $fetchCollection = true, ?bool $useOutputWalkers = null): ORMResult
    {
        return new ORMResult($qb, $fetchCollection, $useOutputWalkers);
    }
}