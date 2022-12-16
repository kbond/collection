<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests\Lazy;

use Zenstruck\Collection\LazyCollection;
use Zenstruck\Collection\Tests\LazyCollectionTest;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class ArrayTest extends LazyCollectionTest
{
    /**
     * @test
     */
    public function can_use_negative_values_for_take_page(): void
    {
        $collection = new LazyCollection(['a', 'b', 'c', 'd', 'e']);

        $this->assertSame(['a', 'b'], \array_values(\iterator_to_array($collection->take(-3))));
        $this->assertSame(['c', 'd'], \array_values(\iterator_to_array($collection->take(2, -3))));
    }

    protected function createWithItems(int $count): LazyCollection
    {
        return new LazyCollection($count ? \range(1, $count) : []);
    }
}
