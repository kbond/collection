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
use Zenstruck\Collection\LazyCollection;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class LazyCollectionTest extends TestCase
{
    use CollectionTests;

    abstract protected function createWithItems(int $count): LazyCollection;
}
