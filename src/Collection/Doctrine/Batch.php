<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ObjectManager;
use Zenstruck\Collection\Doctrine\Batch\BatchIterator;
use Zenstruck\Collection\Doctrine\Batch\BatchProcessor;
use Zenstruck\Collection\Doctrine\Batch\CountableBatchIterator;
use Zenstruck\Collection\Doctrine\Batch\CountableBatchProcessor;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class Batch
{
    private function __construct()
    {
    }

    /**
     * @template V
     *
     * @param iterable<V> $items
     *
     * @return \Traversable<V>
     */
    public static function iterate(iterable $items, ObjectManager $om, int $chunkSize = 100): \Traversable
    {
        if (\is_countable($items)) {
            return new CountableBatchIterator($items, $om, $chunkSize);
        }

        return new BatchIterator($items, $om, $chunkSize);
    }

    /**
     * @template V
     *
     * @param iterable<V> $items
     *
     * @return \Traversable<V>
     */
    public static function process(iterable $items, ObjectManager $om, int $chunkSize = 100): \Traversable
    {
        if (\is_countable($items)) {
            return new CountableBatchProcessor($items, $om, $chunkSize);
        }

        return new BatchProcessor($items, $om, $chunkSize);
    }

    /**
     * @return \Traversable<mixed>
     */
    public static function iteratorFor(Query|QueryBuilder $query, int $chunkSize = 100): \Traversable
    {
        if ($query instanceof QueryBuilder) {
            $query = $query->getQuery();
        }

        return new CountableBatchIterator(new Paginator($query), $query->getEntityManager(), $chunkSize);
    }

    /**
     * @return \Traversable<mixed>
     */
    public static function processorFor(Query|QueryBuilder $query, int $chunkSize = 100): \Traversable
    {
        if ($query instanceof QueryBuilder) {
            $query = $query->getQuery();
        }

        return new CountableBatchProcessor(new Paginator($query), $query->getEntityManager(), $chunkSize);
    }
}
