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
 * @extends BatchProcessor<V>
 */
final class CountableBatchProcessor extends BatchProcessor implements \Countable
{
    /**
     * @param array<V>|(iterable<V>&\Countable) $items
     */
    public function __construct(iterable $items, ObjectManager $om, int $chunkSize = 100)
    {
        parent::__construct($items, $om, $chunkSize);
    }

    public function count(): int
    {
        return \is_countable($this->items) ? \count($this->items) : throw new \LogicException('Not countable.');
    }
}
