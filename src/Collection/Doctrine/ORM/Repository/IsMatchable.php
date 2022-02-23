<?php

namespace Zenstruck\Collection\Doctrine\ORM\Repository;

use Doctrine\ORM\QueryBuilder;
use Zenstruck\Collection\Doctrine\ORM\Repository;
use Zenstruck\Collection\Doctrine\ORM\Result;
use Zenstruck\Collection\Doctrine\ORM\Specification\ORMContext;
use Zenstruck\Collection\Specification\Interpreter;
use Zenstruck\Collection\Specification\SpecificationInterpreter;

/**
 * Enables your repository to implement Zenstruck\Collection\Matchable.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 * @template R of Result
 */
trait IsMatchable
{
    /**
     * @return R<V>
     */
    final public function match(mixed $specification): Result
    {
        if (!$this instanceof Repository) {
            throw new \BadMethodCallException(\sprintf('"%s" can only be used on instances of "%s".', __TRAIT__, Repository::class));
        }

        return static::createResult($this->qbForSpecification($specification));
    }

    /**
     * @return V
     */
    final public function matchOne(mixed $specification): object
    {
        if (!$this instanceof Repository) {
            throw new \BadMethodCallException(\sprintf('"%s" can only be used on instances of "%s".', __TRAIT__, Repository::class));
        }

        if (!\is_object($result = $this->qbForSpecification($specification)->getQuery()->getOneOrNullResult())) {
            throw $this->matchNotFoundException($specification);
        }

        /** @var V $result */
        return $result;
    }

    protected function qbForSpecification(mixed $specification): QueryBuilder
    {
        $result = $this->specificationInterpreter()->interpret(
            $specification,
            new ORMContext($qb = $this->qb('entity'), 'entity')
        );

        if ($result) {
            $qb->where($result);
        }

        return $qb;
    }

    /**
     * Override to provide your own implementation.
     */
    protected function matchNotFoundException(mixed $specification): \RuntimeException
    {
        return new \RuntimeException(\sprintf('Object "%s" not found for specification "%s".', $this->getClassName(), SpecificationInterpreter::stringify($specification)));
    }

    /**
     * Override to provide your own Specification Interpreter implementation.
     */
    protected function specificationInterpreter(): Interpreter
    {
        return ORMContext::defaultInterpreter();
    }
}