<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests\Doctrine\DBAL;

use PHPUnit\Framework\TestCase;
use Zenstruck\Collection\Tests\Doctrine\DBAL\Fixture\ObjectRepository;
use Zenstruck\Collection\Tests\Doctrine\Fixture\Entity;
use Zenstruck\Collection\Tests\Doctrine\HasDatabase;
use Zenstruck\Collection\Tests\Doctrine\SpecificationRepositoryTests;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class ObjectRepositoryTest extends TestCase
{
    use HasDatabase, SpecificationRepositoryTests;

    protected function createWithItems(int $count): ObjectRepository
    {
        $this->persistEntities($count);

        return new ObjectRepository($this->em->getConnection());
    }

    protected function expectedValueAt(int $position): Entity
    {
        return new Entity("value {$position}", $position);
    }
}
