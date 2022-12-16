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
final class FloatResultTest extends ResultTest
{
    /**
     * @test
     */
    public function result_must_be_numeric(): void
    {
        $this->createWithItems(2);

        $result = (new Result($this->em->createQueryBuilder()->select('e.value')->from(Entity::class, 'e')))->asFloat();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Expected result(s) to be "float" but got "string".');

        $result->first();
    }

    protected function expectedValueAt(int $position)
    {
        return (float) $position;
    }

    protected function createWithItems(int $count): Result
    {
        $this->persistEntities($count);

        return (new Result($this->em->createQueryBuilder()->select('e.id')->from(Entity::class, 'e')))->asFloat();
    }
}
