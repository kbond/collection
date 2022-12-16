<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\DBAL;

use Doctrine\DBAL\Query\QueryBuilder;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V
 * @extends Repository<V>
 */
abstract class ObjectRepository extends Repository
{
    /**
     * @return ObjectResult<V>
     */
    protected static function createResult(QueryBuilder $qb): ObjectResult
    {
        return new ObjectResult(fn(array $data) => static::createObject($data), $qb, static::countModifier());
    }

    /**
     * @param mixed[] $data
     */
    abstract protected static function createObject(array $data): object;
}
