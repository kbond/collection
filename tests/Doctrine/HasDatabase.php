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

use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Zenstruck\Collection\Tests\Doctrine\Fixture\Entity;
use Zenstruck\Collection\Tests\Doctrine\Fixture\Relation;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
trait HasDatabase
{
    protected ?EntityManager $em = null;

    /**
     * @before
     */
    protected function setupEntityManager(): void
    {
        $this->em = EntityManager::create(
            ['driver' => 'pdo_sqlite', 'memory' => true],
            Setup::createAttributeMetadataConfiguration([], true)
        );

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->createSchema([
            $this->em->getClassMetadata(Entity::class),
            $this->em->getClassMetadata(Relation::class),
        ]);
    }

    /**
     * @after
     */
    protected function teardownEntityManager(): void
    {
        $this->em = null;
    }

    protected function assertQueryCount(int $expected, callable $callback): void
    {
        $logger = new DebugStack();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($logger);

        $callback();

        if ($expected === \count($logger->queries)) {
            $this->assertTrue(true);

            return;
        }

        $this->fail(\sprintf('Expected %d queries but got %d.', $expected, \count($logger->queries)));
    }

    protected function persistEntities(int $count): void
    {
        $this->setupEntityManager();

        for ($i = 0; $i < $count; ++$i) {
            $this->em->persist(new Entity('value '.($i + 1)));
        }

        $this->flushAndClear();
    }

    protected function flushAndClear(): void
    {
        $this->em->flush();
        $this->em->clear();
    }
}
