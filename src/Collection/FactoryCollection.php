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
 * @template K
 * @template V
 * @implements Collection<K,V>
 */
final class FactoryCollection implements Collection
{
    /** @use IterableCollection<K,V> */
    use IterableCollection;

    /** @var Collection<K,mixed> */
    private Collection $inner;
    private \Closure $factory;

    /**
     * @template T
     *
     * @param Collection<K,T> $collection
     * @param callable(T):V   $factory
     */
    public function __construct(Collection $collection, callable $factory)
    {
        $this->inner = $collection;
        $this->factory = $factory(...);
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->inner as $key => $value) {
            yield $key => ($this->factory)($value);
        }
    }

    public function count(): int
    {
        return $this->inner->count();
    }
}
