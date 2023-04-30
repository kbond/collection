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

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @author Marco Pivetta <ocramius@gmail.com>
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @internal
 *
 * @template V
 * @implements \IteratorAggregate<V>
 */
class BatchProcessor implements \IteratorAggregate
{
    /**
     * @param iterable<V> $items
     */
    public function __construct(protected iterable $items, private ObjectManager $om, private int $chunkSize = 100)
    {
    }

    final public function getIterator(): \Traversable
    {
        if ($this->om instanceof EntityManagerInterface) {
            $this->om->beginTransaction();
        }

        $iteration = 0;

        try {
            foreach ($this->items as $key => $value) {
                yield $key => $value;

                $this->flushAndClearBatch(++$iteration);
            }
        } catch (\Throwable $e) {
            if ($this->om instanceof EntityManagerInterface) {
                $this->om->rollback();
            }

            throw $e;
        }

        $this->flushAndClear();

        if ($this->om instanceof EntityManagerInterface) {
            $this->om->commit();
        }
    }

    private function flushAndClearBatch(int $iteration): void
    {
        if ($iteration % $this->chunkSize) {
            return;
        }

        $this->flushAndClear();
    }

    private function flushAndClear(): void
    {
        $this->om->flush();
        $this->om->clear();
    }
}
