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

use Doctrine\ORM\EntityRepository;
use Zenstruck\Collection\Doctrine\ORM\EntityRepositoryBridge;
use Zenstruck\Collection\Repository\ObjectRepository;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 * @extends EntityRepository<V>
 * @implements ObjectRepository<V>
 */
class ORMEntityRepository extends EntityRepository implements ObjectRepository
{
    /** @use EntityRepositoryBridge<V> */
    use EntityRepositoryBridge;
}
