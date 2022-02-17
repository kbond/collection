<?php

namespace Zenstruck\Collection\Doctrine\ORM\Repository;

use Zenstruck\Collection\Doctrine\ORM\Repository;

/**
 * Allows your repository to flush pending changes to the db.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
trait Flushable
{
    final public function flush(): static
    {
        if (!$this instanceof Repository) {
            throw new \BadMethodCallException(\sprintf('"%s" can only be used on instances of "%s".', __TRAIT__, Repository::class));
        }

        $this->em()->flush();

        return $this;
    }
}
