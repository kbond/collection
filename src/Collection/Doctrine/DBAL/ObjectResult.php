<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\DBAL;

use Doctrine\DBAL\Query\QueryBuilder;
use Zenstruck\Collection;
use Zenstruck\Collection\FactoryCollection;
use Zenstruck\Collection\LazyCollection;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V
 * @extends Result<V>
 */
class ObjectResult extends Result
{
    private \Closure $factory;

    public function __construct(callable $factory, QueryBuilder $qb, ?callable $countModifier = null)
    {
        $this->factory = \Closure::fromCallable($factory);

        parent::__construct($qb, $countModifier);
    }

    public function take(int $limit, int $offset = 0): Collection
    {
        return new FactoryCollection(parent::take($limit, $offset), $this->factory);
    }

    public function getIterator(): \Traversable
    {
        return new FactoryCollection(new LazyCollection(fn() => parent::getIterator()), $this->factory);
    }
}
