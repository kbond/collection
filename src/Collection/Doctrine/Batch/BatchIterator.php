<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\Batch;

use Doctrine\Persistence\ObjectManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @internal
 *
 * @template V
 * @implements \IteratorAggregate<int,V>
 */
class BatchIterator implements \IteratorAggregate
{
    /**
     * @param iterable<V> $items
     */
    public function __construct(protected readonly iterable $items, private ObjectManager $om, private int $chunkSize = 100)
    {
    }

    final public function getIterator(): \Traversable
    {
        $iteration = 0;

        foreach ($this->items as $key => $value) {
            yield $key => $value;

            if (++$iteration % $this->chunkSize) {
                continue;
            }

            $this->om->clear();
        }

        $this->om->clear();
    }
}
