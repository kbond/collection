<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Zenstruck\Collection\DoctrineCollection;
use Zenstruck\Collection\Tests\DoctrineCollectionTest;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class InnerDoctrineCollectionTest extends DoctrineCollectionTest
{
    protected function createWithItems(int $count): DoctrineCollection
    {
        return new DoctrineCollection(new ArrayCollection($count ? \range(1, $count) : []));
    }
}
