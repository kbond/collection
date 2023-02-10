<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck;

use Zenstruck\Collection\LazyCollection;

/**
 * @template K of array-key
 * @template V
 *
 * @param null|iterable<K,V>|callable():iterable<K,V> $source
 *
 * @return LazyCollection<K,V>
 */
function collect(iterable|callable|null $source = null): LazyCollection
{
    return new LazyCollection($source);
}
