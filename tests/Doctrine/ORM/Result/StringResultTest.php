<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests\Doctrine\ORM\Result;

use Zenstruck\Collection\Doctrine\ORM\Result;
use Zenstruck\Collection\Tests\Doctrine\Fixture\Entity;
use Zenstruck\Collection\Tests\Doctrine\ORM\ResultTest;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class StringResultTest extends ResultTest
{
    protected function expectedValueAt(int $position)
    {
        return (string) $position;
    }

    protected function createWithItems(int $count): Result
    {
        $this->persistEntities($count);

        return Result::for($this->em->createQueryBuilder()->select('e.id')->from(Entity::class, 'e'))->asString();
    }
}
