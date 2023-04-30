<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests\Doctrine\Batch;

use PHPUnit\Framework\TestCase;
use Zenstruck\Collection\Doctrine\Batch;
use Zenstruck\Collection\Tests\Doctrine\Fixture\Entity;
use Zenstruck\Collection\Tests\Doctrine\HasDatabase;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class BatchIteratorTest extends TestCase
{
    use HasDatabase;

    /**
     * @test
     */
    public function detaches_entities_from_em_on_iterate(): void
    {
        $this->persistEntities(2);
        $iterator = Batch::iterate($this->em->getRepository(Entity::class)->findAll(), $this->em, 1);

        $result = \iterator_to_array($iterator)[0];

        $this->assertInstanceOf(Entity::class, $result);
        $this->assertFalse($this->em->contains($result));
    }

    /**
     * @test
     */
    public function countable_iterator(): void
    {
        $this->assertCount(3, Batch::iterate([1, 2, 3], $this->em));
    }
}
