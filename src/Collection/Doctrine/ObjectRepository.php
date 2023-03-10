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

use Zenstruck\Collection\Repository;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 * @extends Repository<V>
 */
interface ObjectRepository extends Repository
{
    public function get(mixed $specification): object;

    public function find(mixed $specification): ?object;
}
