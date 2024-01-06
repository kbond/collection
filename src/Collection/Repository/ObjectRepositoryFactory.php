<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Repository;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
interface ObjectRepositoryFactory
{
    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return ObjectRepository<T>
     */
    public function create(string $class): ObjectRepository;
}
