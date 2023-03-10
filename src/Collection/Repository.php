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

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V
 * @extends \IteratorAggregate<array-key,V>
 */
interface Repository extends \IteratorAggregate, \Countable
{
    /**
     * @return V
     *
     * @throws \RuntimeException If no result
     */
    public function get(mixed $specification): mixed;

    /**
     * @return V|null
     */
    public function find(mixed $specification): mixed;

    /**
     * @return Collection<array-key,V>
     */
    public function filter(mixed $specification): Collection;
}
