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

use Zenstruck\Collection\ArrayCollection;
use Zenstruck\Collection\Page;
use Zenstruck\Collection\Pages;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template K
 * @template V
 * @extends \IteratorAggregate<K,V>
 *
 * @method static dump()
 * @method never  dd()
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
     * @template T
     *
     * @param callable(V,K):T $function
     *
     * @return self<T,V>
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
     * @template D
     *
     * @param callable(V,K):bool $predicate
     * @param D                  $default
     *
     * @return V|D
     */
    public function find(callable $predicate, mixed $default = null): mixed;

    /**
     * @template T
     *
     * @param callable(T,V,K):T $function
     * @param T                 $initial
     *
     * @return T
     */
    public function reduce(callable $function, mixed $initial = null): mixed;

    public function isEmpty(): bool;

    /**
     * @return ArrayCollection<K&array-key,V>
     */
    public function eager(): ArrayCollection;

    /**
     * @return Page<K,V>
     */
    public function paginate(int $page = 1, int $limit = Page::DEFAULT_LIMIT): Page;

    /**
     * @return Pages<K,V>
     */
    public function pages(int $limit = Page::DEFAULT_LIMIT): Pages;
}
