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
final class CallbackCollection implements Collection
{
    /** @use IterableCollection<K,V> */
    use IterableCollection;

    /** @var LazyCollection<K,V> */
    private LazyCollection $iterator;
    private \Closure $count;

    public function __construct(callable $iterator, callable $count)
    {
        $this->iterator = new LazyCollection($iterator);
        $this->count = $count(...);
    }

    public function getIterator(): \Traversable
    {
        return $this->iterator;
    }

    public function count(): int
    {
        return ($this->count)();
    }
}
