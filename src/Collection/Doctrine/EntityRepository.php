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
use Doctrine\ORM\EntityRepository as ORMEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zenstruck\Collection\Doctrine\ORM\Result;
use Zenstruck\Collection\Doctrine\ORM\ResultQueryBuilder;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 * @implements ObjectRepository<V>
 */
class EntityRepository implements ObjectRepository
{
    /** @var ORMEntityRepository<V> */
    private ORMEntityRepository $ormRepo;

    /**
     * @param class-string<V>|null $class
     */
    public function __construct(private ManagerRegistry|EntityManagerInterface $registry, private ?string $class = null)
    {
    }

    public function get(mixed $specification): object
    {
        return $this->find($specification) ?? throw new \RuntimeException('todo');
    }

    public function find(mixed $specification): ?object
    {
        return $this->ormRepo()->find($specification);
    }

    /**
     * @param array<string,scalar> $specification
     *
     * @return Result<V>
     */
    public function filter(mixed $specification): Result
    {
        if (!\is_array($specification)) {
            throw new \LogicException();
        }

        $qb = $this->qb('e');

        foreach ($specification as $field => $value) {
            $qb->andWhere("e.{$field} = :{$field}")->setParameter($field, $value);
        }

        return $qb->result();
    }

    public function getIterator(): \Traversable
    {
        return $this->qb('e')->result()->batch();
    }

    public function count(): int
    {
        return $this->qb('e')->result()->count();
    }

    /**
     * @return ResultQueryBuilder<V>
     */
    protected function qb(string $alias, ?string $indexBy = null): ResultQueryBuilder
    {
        return (new ResultQueryBuilder($this->em()))
            ->select($alias)
            ->from($this->entityClass(), $alias, $indexBy)
        ;
    }

    final protected function em(): EntityManagerInterface
    {
        if ($this->registry instanceof EntityManagerInterface) {
            return $this->registry;
        }

        if (!($em = $this->registry->getManagerForClass($this->entityClass())) instanceof EntityManagerInterface) {
            throw new \LogicException();
        }

        return $this->registry = $em;
    }

    /**
     * @return ORMEntityRepository<V>
     */
    final protected function ormRepo(): ORMEntityRepository
    {
        return $this->ormRepo ??= $this->em()->getRepository($this->entityClass());
    }

    /**
     * @return class-string<V>
     */
    private function entityClass(): string
    {
        if ($this->class) {
            return $this->class;
        }

        if ($attribute = (new \ReflectionClass(static::class))->getAttributes(ForClass::class)[0] ?? null) {
            return $this->class = $attribute->newInstance()->name; // @phpstan-ignore-line
        }

        throw new \LogicException();
    }
}
