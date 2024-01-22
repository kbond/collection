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

use Doctrine\Common\Collections\Criteria;
use Zenstruck\Collection\Exception\InvalidSpecification;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 * @extends \IteratorAggregate<int,V>
 */
interface ObjectRepository extends \Countable, \IteratorAggregate
{
    public const ALL = null;

    /**
     * @param mixed|array|Criteria $specification
     *
     * @return ?V
     */
    public function find(mixed $specification): ?object;

    /**
     * @param mixed|self::ALL|array|Criteria $specification
     *
     * @return Result<V>
     *
     * @throws InvalidSpecification if the specification is not supported
     */
    public function query(mixed $specification): Result;
}
