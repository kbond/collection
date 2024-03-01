<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Grid;

use Zenstruck\Collection\ArrayCollection;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template T of array<string,mixed>|object
 *
 * @implements \IteratorAggregate<string,Action<T>>
 */
final class Actions implements \IteratorAggregate, \Countable
{
    /**
     * @param ArrayCollection<string,Action<T>> $actions
     *@internal
     */
    public function __construct(private ArrayCollection $actions)
    {
    }

    /**
     * @return ?Action<T>
     */
    public function get(string $name): ?Action
    {
        return $this->actions->get($name);
    }

    public function has(string $name): bool
    {
        return $this->actions->has($name);
    }

    /**
     * @param T $item
     *
     * @return $this
     */
    public function visible(array|object $item): self
    {
        return new self($this->actions->filter(fn(Action $a) => $a->isVisible($item)));
    }

    /**
     * @return ArrayCollection<string,Action<T>>
     */
    public function all(): ArrayCollection
    {
        return $this->actions;
    }

    public function getIterator(): \Traversable
    {
        return $this->actions;
    }

    public function count(): int
    {
        return $this->actions->count();
    }
}
