<?php

namespace Zenstruck\Collection\Tests\Iterable;

use Zenstruck\Collection\IterableCollection;
use Zenstruck\Collection\Tests\IterableCollectionTest;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class CallableArrayTest extends IterableCollectionTest
{
    protected function createWithItems(int $count): IterableCollection
    {
        $object = new class($count) {
            public function __construct(private $count)
            {
            }

            public function values()
            {
                return $this->count ? \range(1, $this->count) : [];
            }
        };

        return new IterableCollection([$object, 'values']);
    }
}
