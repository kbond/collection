<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Repository;

use Doctrine\Common\Collections\Criteria;
use Zenstruck\Collection\Doctrine\Result;
use Zenstruck\Collection\Repository;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 * @extends Repository<V>
 */
interface ObjectRepository extends Repository
{
    /**
     * @param mixed|array|Criteria $specification
     */
    public function find(mixed $specification): ?object;

    /**
     * @param mixed|null|array|Criteria $specification
     *
     * @return Result<V>
     */
    public function query(mixed $specification): Result;
}
