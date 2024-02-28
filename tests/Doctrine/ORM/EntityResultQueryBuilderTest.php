<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doctrine\ORM;

use PHPUnit\Framework\TestCase;
use Zenstruck\Collection\Doctrine\ORM\EntityResultQueryBuilder;
use Zenstruck\Collection\Tests\Doctrine\Fixture\Entity;
use Zenstruck\Collection\Tests\Doctrine\HasDatabase;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class EntityResultQueryBuilderTest extends TestCase
{
    use HasDatabase;

    /**
     * @test
     */
    public function can_mark_as_readonly(): void
    {
        $this->persistEntities(1);

        $entity = EntityResultQueryBuilder::forEntity($this->em, Entity::class, 'e')
            ->readonly()
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;

        $this->assertTrue($this->em->getUnitOfWork()->isReadOnly($entity));
    }

    /**
     * @test
     */
    public function result_is_marked_as_readonly(): void
    {
        $this->persistEntities(1);

        $entity = EntityResultQueryBuilder::forEntity($this->em, Entity::class, 'e')
            ->readonly()
            ->setMaxResults(1)
            ->result()
            ->first()
        ;

        $this->assertFalse($this->em->contains($entity));
    }
}
