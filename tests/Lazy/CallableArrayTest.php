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
final class CallableArrayTest extends LazyCollectionTest
{
    protected function createWithItems(int $count): LazyCollection
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

        return new LazyCollection([$object, 'values']);
    }
}
