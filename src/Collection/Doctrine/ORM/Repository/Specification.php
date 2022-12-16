<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\ORM\Repository;

use Zenstruck\Collection\Doctrine\ORM\EntityRepository;
use Zenstruck\Collection\Doctrine\ORM\Result;
use Zenstruck\Collection\Doctrine\ORM\ResultQueryBuilder;
use Zenstruck\Collection\Doctrine\ORM\Specification\ORMContext;
use Zenstruck\Collection\Specification\Interpreter;
use Zenstruck\Collection\Specification\SpecificationInterpreter;

/**
 * Enables your repository to use the specification system.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 */
trait Specification
{
    /**
     * @param mixed|array<string,mixed> $specification
     *
     * @return Result<V>
     */
    final public function filter(mixed $specification): Result
    {
        if (!$this instanceof EntityRepository) {
            throw new \BadMethodCallException(\sprintf('"%s" can only be used on instances of "%s".', __TRAIT__, EntityRepository::class));
        }

        if (\is_array($specification) && !array_is_list($specification)) {
            // using standard "criteria"
            return parent::filter($specification);
        }

        return $this->qbForSpecification($specification)->result();
    }

    /**
     * @return V
     */
    final public function get(mixed $specification): object
    {
        if (!$this instanceof EntityRepository) {
            throw new \BadMethodCallException(\sprintf('"%s" can only be used on instances of "%s".', __TRAIT__, EntityRepository::class));
        }

        if (\is_scalar($specification) || (\is_array($specification) && !array_is_list($specification))) {
            // using id
            return parent::get($specification);
        }

        if (!\is_object($result = $this->qbForSpecification($specification)->result()->first())) {
            throw $this->createNotFoundForSpecificationException($specification);
        }

        /** @var V $result */
        return $result;
    }

    /**
     * @return ResultQueryBuilder<V>
     */
    protected function qbForSpecification(mixed $specification): ResultQueryBuilder
    {
        $result = $this->specificationInterpreter()->interpret(
            $specification,
            new ORMContext($qb = $this->createQueryBuilder('entity'), 'entity')
        );

        if ($result) {
            $qb->where($result);
        }

        return $qb;
    }

    /**
     * Override to customize the "specification not found" exception.
     */
    protected function createNotFoundForSpecificationException(mixed $specification): \RuntimeException
    {
        return new (static::notFoundExceptionClass())(\sprintf('Object "%s" not found for specification "%s".', $this->getClassName(), SpecificationInterpreter::stringify($specification)));
    }

    /**
     * Override to provide your own Specification Interpreter implementation.
     */
    protected function specificationInterpreter(): Interpreter
    {
        return ORMContext::defaultInterpreter();
    }
}
