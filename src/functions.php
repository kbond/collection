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

use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Zenstruck\Collection\Doctrine\DoctrineBridgeCollection;
use Zenstruck\Collection\LazyCollection;

/**
 * @template K
 * @template V
 *
 * @param null|iterable<K,V>|callable():iterable<K,V> $source
 *
 * @return LazyCollection<K,V>
 * @phpstan-return ($source is null ? Collection<never,never> : Collection<K,V>)
 */
function collect(iterable|callable|null $source = null): Collection
{
    if ($source instanceof Collection) {
        return $source;
    }

    if ($source instanceof DoctrineCollection) {
        return new DoctrineBridgeCollection($source);
    }

    return new LazyCollection($source ?? []);
}
