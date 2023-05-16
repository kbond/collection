<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template K of array-key
 * @template V
 * @extends \IteratorAggregate<K,V>
 */
interface Collection extends \IteratorAggregate, \Countable
{
    /**
     * @param callable(V,K):bool $predicate
     *
     * @return self<K,V>
     */
    public function filter(callable $predicate): self;

    /**
     * @template T
     *
     * @param callable(V,K):T $function
     *
     * @return self<K,T>
     */
    public function map(callable $function): self;

    /**
     * @template T of array-key|\Stringable
     *
     * @param callable(V,K):T $function
     *
     * @return self<array-key,V>
     */
    public function keyBy(callable $function): self;

    /**
     * @return self<K,V>
     */
    public function take(int $limit, int $offset = 0): self;

    /**
     * @template D
     *
     * @param D $default
     *
     * @return V|D
     */
    public function first(mixed $default = null): mixed;

    /**
     * @template T
     *
     * @param callable(T,V,K):T $function
     * @param T                 $initial
     *
     * @return T
     */
    public function reduce(callable $function, mixed $initial = null): mixed;
}
