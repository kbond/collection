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

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Zenstruck\Collection\Doctrine\ObjectRepository;
use Zenstruck\Collection\Doctrine\ORM\EntityRepositoryBridge;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 * @extends ServiceEntityRepository<V>
 * @implements ObjectRepository<V>
 */
class ORMServiceEntityRepository extends ServiceEntityRepository implements ObjectRepository
{
    /** @use EntityRepositoryBridge<V> */
    use EntityRepositoryBridge;
}
