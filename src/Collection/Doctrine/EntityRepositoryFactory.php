<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class EntityRepositoryFactory implements ObjectRepositoryFactory
{
    /** @var array<class-string,EntityRepository<object>> */
    private array $cache = [];

    /**
     * @param ContainerInterface|array<class-string,EntityRepository<object>> $locator
     * @param class-string<EntityRepository<object>>                          $defaultEntityRepository
     */
    public function __construct(
        private ManagerRegistry $registry,
        private ContainerInterface|array $locator = [],
        private string $defaultEntityRepository = EntityRepository::class,
    ) {
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return EntityRepository<T>
     */
    public function create(string $class): EntityRepository
    {
        if (isset($this->cache[$class])) {
            return $this->cache[$class]; // @phpstan-ignore-line
        }

        if ($repo = $this->locate($class)) {
            return $this->cache[$class] = $repo; // @phpstan-ignore-line
        }

        if (!($em = $this->registry->getManagerForClass($class)) instanceof EntityManagerInterface) {
            throw new \LogicException();
        }

        return $this->cache[$class] = new ($this->defaultEntityRepository)($em, $class); // @phpstan-ignore-line
    }

    /**
     * @param class-string $class
     *
     * @return EntityRepository<object>|null
     */
    private function locate(string $class): ?EntityRepository
    {
        if (\is_array($this->locator)) {
            return $this->locator[$class] ?? null;
        }

        try {
            return $this->locator->get($class);
        } catch (NotFoundExceptionInterface) {
            return null;
        }
    }
}
