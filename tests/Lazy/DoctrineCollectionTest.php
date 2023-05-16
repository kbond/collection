<?php

namespace Zenstruck\Collection\Tests\Lazy;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\PersistentCollection;
use Zenstruck\Collection\LazyCollection;
use Zenstruck\Collection\Tests\Doctrine\Fixture\Entity;
use Zenstruck\Collection\Tests\Doctrine\Fixture\Relation;
use Zenstruck\Collection\Tests\Doctrine\HasDatabase;
use Zenstruck\Collection\Tests\LazyCollectionTest;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class DoctrineCollectionTest extends LazyCollectionTest
{
    use HasDatabase;

    /**
     * @test
     */
    public function counting_extra_lazy_does_not_initialize_collection(): void
    {
        [$persistentCollection, $entities] = $this->createExtraLazyCollection();

        $this->assertCount(3, $entities);
        $this->assertFalse($persistentCollection->isInitialized());
    }

    /**
     * @test
     */
    public function first_extra_lazy_does_not_initialize_collection(): void
    {
        [$persistentCollection, $entities] = $this->createExtraLazyCollection();

        $this->assertEquals('value 1', $entities->first()->value);
        $this->assertFalse($persistentCollection->isInitialized());
    }

    /**
     * @test
     */
    public function take_extra_lazy_does_not_initialize_collection(): void
    {
        [$persistentCollection, $entities] = $this->createExtraLazyCollection();

        $this->assertCount(2, $entities->take(2));
        $this->assertFalse($persistentCollection->isInitialized());
    }

    /**
     * @test
     */
    public function iterating_extra_lazy_does_not_initialize_collection(): void
    {
        [$persistentCollection, $entities] = $this->createExtraLazyCollection();

        foreach ($entities as $entity) {
            $this->assertInstanceof(Entity::class, $entity);
        }

        $this->assertFalse($persistentCollection->isInitialized());
    }

    /**
     * @return array{0:PersistentCollection,1:LazyCollection}
     */
    private function createExtraLazyCollection(): array
    {
        $this->setupEntityManager();

        $this->em->persist($relation = new Relation(1));
        $this->em->persist(Entity::withRelation('value 1', $relation));
        $this->em->persist(Entity::withRelation('value 2', $relation));
        $this->em->persist(Entity::withRelation('value 3', $relation));

        $this->flushAndClear();

        return [
            $persistentCollection = $this->em->find(Relation::class, 1)->getEntities(),
            new LazyCollection($persistentCollection)
        ];
    }

    protected function expectedValueAt(int $position): object
    {
        return new Entity("value {$position}", $position);
    }

    protected function createWithItems(int $count): LazyCollection
    {
        $this->persistEntities($count);

        return new LazyCollection($this->em->getRepository(Entity::class)->matching(new Criteria()));
    }
}
