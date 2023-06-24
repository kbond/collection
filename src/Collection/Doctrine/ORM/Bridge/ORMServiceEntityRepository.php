<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\ORM\Bridge;

use Doctrine\Bundle\DoctrineBundle\Repository\LazyServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarExporter\LazyGhostTrait;
use Symfony\Component\VarExporter\LazyObjectInterface;

if (\trait_exists(LazyGhostTrait::class)) {
    /**
     * @see LazyServiceEntityRepository
     *
     * @author Kevin Bond <kevinbond@gmail.com>
     *
     * @template V of object
     * @extends ORMEntityRepository<V>
     */
    class ORMServiceEntityRepository extends ORMEntityRepository implements ServiceEntityRepositoryInterface
    {
        use LazyGhostTrait {
            createLazyGhost as private;
        }

        /**
         * @param class-string<V> $entityClass
         */
        public function __construct(ManagerRegistry $registry, string $entityClass)
        {
            $initializer = function($instance, $property) use ($registry, $entityClass) {
                $manager = $registry->getManagerForClass($entityClass);

                if (!$manager instanceof EntityManagerInterface) {
                    throw new \LogicException(\sprintf('Could not find the entity manager for class "%s". Check your Doctrine configuration to make sure it is configured to load this entity’s metadata.', $entityClass));
                }

                parent::__construct($manager, $manager->getClassMetadata($entityClass)); // @phpstan-ignore-line

                return $this->{$property};
            };

            if ($this instanceof LazyObjectInterface) {
                $initializer($this, '_entityName');

                return;
            }

            self::createLazyGhost([
                "\0*\0_em" => $initializer,
                "\0*\0_class" => $initializer,
                "\0*\0_entityName" => $initializer,
            ], null, $this);
        }
    }
} else {
    /**
     * @author Kevin Bond <kevinbond@gmail.com>
     *
     * @template V of object
     * @extends ORMEntityRepository<V>
     */
    class ORMServiceEntityRepository extends ORMEntityRepository implements ServiceEntityRepositoryInterface
    {
        /**
         * @param class-string<V> $entityClass
         */
        public function __construct(ManagerRegistry $registry, string $entityClass)
        {
            $manager = $registry->getManagerForClass($entityClass);

            if (!$manager instanceof EntityManagerInterface) {
                throw new \LogicException(\sprintf('Could not find the entity manager for class "%s". Check your Doctrine configuration to make sure it is configured to load this entity’s metadata.', $entityClass));
            }

            parent::__construct($manager, $manager->getClassMetadata($entityClass)); // @phpstan-ignore-line
        }
    }
}
