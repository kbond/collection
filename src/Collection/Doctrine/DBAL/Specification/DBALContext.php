<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\DBAL\Specification;

use Doctrine\DBAL\Query\QueryBuilder;
use Zenstruck\Collection\Doctrine\Specification\Context;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class DBALContext extends Context
{
    private QueryBuilder $qb;

    public function __construct(QueryBuilder $qb, string $alias)
    {
        parent::__construct($alias);

        $this->qb = $qb;
    }

    public function qb(): QueryBuilder
    {
        return $this->qb;
    }

    public function scopeTo(string $alias): self
    {
        return new self($this->qb, $alias);
    }
}
