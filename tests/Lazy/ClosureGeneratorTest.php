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
final class ClosureGeneratorTest extends LazyCollectionTest
{
    /**
     * @test
     */
    public function cannot_create_with_generator_directly(): void
    {
        $collection = new LazyCollection((static fn() => yield 'foo' => 'bar')());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$source must not be a generator directly as generators cannot be rewound. Try wrapping in a closure.');

        $collection->count();
    }

    /**
     * @test
     */
    public function can_create_with_generator_if_calling_eager_immediately(): void
    {
        $collection = new LazyCollection((static fn() => yield 'foo' => 'bar')());

        $this->assertSame(['foo' => 'bar'], $collection->eager()->all());
    }

    /**
     * @test
     */
    public function can_count_multiple_times(): void
    {
        $collection = $this->createWithItems(5);

        $this->assertCount(5, $collection);
        $this->assertCount(5, $collection);
    }

    protected function createWithItems(int $count): LazyCollection
    {
        return new LazyCollection(static function() use ($count) {
            for ($i = 1; $i <= $count; ++$i) {
                yield $i;
            }
        });
    }
}
