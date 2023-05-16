<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Pagerfanta;

use Pagerfanta\Adapter\AdapterInterface;
use Zenstruck\Collection;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template K of array-key
 * @template V
 * @implements AdapterInterface<V>
 */
final class PagerfantaAdapter implements AdapterInterface
{
    /** @var Collection<K,V> */
    private Collection $collection;

    /**
     * @param Collection<K,V> $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function getNbResults(): int
    {
        return $this->collection->count(); // @phpstan-ignore-line
    }

    public function getSlice($offset, $length): iterable
    {
        return $this->collection->take($length, $offset);
    }
}
