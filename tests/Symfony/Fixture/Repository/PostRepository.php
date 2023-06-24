<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests\Symfony\Fixture\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Zenstruck\Collection\Doctrine\ORM\Bridge\ORMServiceEntityRepository;
use Zenstruck\Collection\Tests\Symfony\Fixture\Entity\Post;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @extends ORMServiceEntityRepository<Post>
 */
final class PostRepository extends ORMServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }
}
