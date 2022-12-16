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

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V
 * @extends BatchIterator<V>
 */
final class CountableBatchIterator extends BatchIterator implements \Countable
{
    public function count(): int
    {
        return \is_countable($this->items) ? \count($this->items) : throw new \LogicException('Not countable.');
    }
}
