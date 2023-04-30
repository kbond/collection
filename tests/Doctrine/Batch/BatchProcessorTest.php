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
final class BatchProcessorTest extends TestCase
{
    use HasDatabase;

    /**
     * @test
     */
    public function detaches_entities_from_em_on_iterate(): void
    {
        $this->persistEntities(2);
        $iterator = Batch::process($this->em->getRepository(Entity::class)->findAll(), $this->em, 1);

        $result = \iterator_to_array($iterator)[0];

        $this->assertInstanceOf(Entity::class, $result);
        $this->assertFalse($this->em->contains($result));
    }

    /**
     * @test
     */
    public function can_batch_persist_results(): void
    {
        $array = [];

        for ($i = 1; $i <= 211; ++$i) {
            $array[] = 'value '.$i;
        }

        $batchProcessor = Batch::process($array, $this->em);

        foreach ($batchProcessor as $item) {
            $this->em->persist(new Entity($item));
        }

        $entities = $this->em->getRepository(Entity::class)->findAll();

        $this->assertCount(211, $entities);
        $this->assertSame('value 32', $entities[31]->value);
        $this->assertSame('value 200', $entities[199]->value);
        $this->assertSame('value 211', $entities[210]->value);
    }

    /**
     * @test
     */
    public function can_batch_persist_new_entities(): void
    {
        $array = [];

        for ($i = 1; $i <= 211; ++$i) {
            $array[] = new Entity('value '.$i);
        }

        $batchProcessor = Batch::process($array, $this->em);

        foreach ($batchProcessor as $item) {
            $this->em->persist($item);
        }

        $entities = $this->em->getRepository(Entity::class)->findAll();

        $this->assertCount(211, $entities);
        $this->assertSame('value 32', $entities[31]->value);
        $this->assertSame('value 200', $entities[199]->value);
        $this->assertSame('value 211', $entities[210]->value);
    }

    /**
     * @test
     */
    public function can_batch_persist_results_from_iterator(): void
    {
        $array = [];

        for ($i = 1; $i <= 211; ++$i) {
            $array[] = 'value '.$i;
        }

        $batchProcessor = Batch::process(new \ArrayIterator($array), $this->em);

        foreach ($batchProcessor as $item) {
            $this->em->persist(new Entity($item));
        }

        $entities = $this->em->getRepository(Entity::class)->findAll();

        $this->assertCount(211, $entities);
        $this->assertSame('value 32', $entities[31]->value);
        $this->assertSame('value 200', $entities[199]->value);
        $this->assertSame('value 211', $entities[210]->value);
    }

    /**
     * @test
     */
    public function can_batch_persist_array_of_arrays(): void
    {
        $array = [];

        for ($i = 1; $i <= 211; ++$i) {
            $array[] = ['value', $i];
        }

        $batchProcessor = Batch::process($array, $this->em);

        foreach ($batchProcessor as [$value, $id]) {
            $this->em->persist(new Entity($value.' '.$id));
        }

        $entities = $this->em->getRepository(Entity::class)->findAll();

        $this->assertCount(211, $entities);
        $this->assertSame('value 32', $entities[31]->value);
        $this->assertSame('value 200', $entities[199]->value);
        $this->assertSame('value 211', $entities[210]->value);
    }

    /**
     * @test
     */
    public function results_do_not_have_to_be_countable(): void
    {
        $iterator = static function() {
            yield 'foo';
        };
        $batchProcessor = Batch::process($iterator(), $this->em);

        $this->assertFalse(\is_countable($batchProcessor));
        $this->assertSame(['foo'], \iterator_to_array($batchProcessor));
    }

    /**
     * @test
     */
    public function countable_processor(): void
    {
        $this->assertCount(3, Batch::process([1, 2, 3], $this->em));
    }
}
