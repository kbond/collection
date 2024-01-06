<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection;

use Zenstruck\Collection;
use Zenstruck\Collection\Exception\InvalidSpecification;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V
 * @extends \IteratorAggregate<int,V>
 */
interface Repository extends \Countable, \IteratorAggregate
{
    /**
     * @return ?V
     */
    public function find(mixed $specification): mixed;

    /**
     * @param mixed|null $specification "null" returns the entire repository as a collection
     *
     * @return Collection<int,V>
     *
     * @throws InvalidSpecification if the specification is not supported
     */
    public function query(mixed $specification): Collection;
}
