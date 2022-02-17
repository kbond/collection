<?php

namespace Zenstruck\Collection\Doctrine\ORM\Repository;

use Zenstruck\Collection;
use Zenstruck\Collection\Doctrine\ORM\Repository;

/**
 * Enables your repository to implement Zenstruck\Collection (and use
 * the Zenstruck\Collection\Paginatable trait).
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V
 */
trait IsCollection
{
    /**
     * @return Collection<int,V>
     */
    final public function take(int $limit, int $offset = 0): Collection
    {
        if (!$this instanceof Repository) {
            throw new \BadMethodCallException(\sprintf('"%s" can only be used on instances of "%s".', __TRAIT__, Repository::class));
        }

        return static::createResult($this->qb())->take($limit, $offset);
    }
}
