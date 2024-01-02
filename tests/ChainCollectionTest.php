<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests;

use PHPUnit\Framework\TestCase;
use Zenstruck\Collection\ArrayCollection;
use Zenstruck\Collection\ChainCollection;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class ChainCollectionTest extends TestCase
{
    use CollectionTests;

    /**
     * @test
     */
    public function can_preserve_keys(): void
    {
        $collection = new ChainCollection(
            [
                new ArrayCollection(['foo' => 'foo value']),
                new ArrayCollection(['bar' => 'bar value', 'foo' => 'foo value 2']),
            ],
            preserveKeys: true,
        );

        $this->assertSame(['foo' => 'foo value 2', 'bar' => 'bar value'], \iterator_to_array($collection));
    }

    protected function createWithItems(int $count): ChainCollection
    {
        if ($count < 2) {
            return new ChainCollection([new ArrayCollection($count ? \range(1, $count) : []), new ArrayCollection()]);
        }

        return new ChainCollection([new ArrayCollection([1]), new ArrayCollection(\range(2, $count))]);
    }
}
