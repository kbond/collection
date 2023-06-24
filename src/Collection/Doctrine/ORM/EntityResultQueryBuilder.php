<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V
 */
final class EntityResultQueryBuilder extends QueryBuilder
{
    /**
     * @param class-string<V> $class
     *
     * @return self<V>
     */
    public static function forEntity(EntityManagerInterface $em, string $class, string $alias, ?string $indexBy = null): self
    {
        return (new self($em))
            ->select($alias)
            ->from($class, $alias, $indexBy)
        ;
    }

    /**
     * @return EntityResult<V>
     */
    public function result(): EntityResult
    {
        return new EntityResult($this);
    }
}
