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
use Zenstruck\Collection\Specification\OrderBy;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template T of array<string,mixed>|object
 *
 * @implements \IteratorAggregate<string,Column<T>>
 */
final class Columns implements \IteratorAggregate, \Countable
{
    /** @var self<T> */
    private self $visible;

    /** @var self<T> */
    private self $searchable;

    /** @var self<T> */
    private self $sortable;

    /**
     * @internal
     *
     * @param ArrayCollection<string,Column<T>> $columns
     */
    public function __construct(private ArrayCollection $columns, private Input $input, private ?OrderBy $defaultSort)
    {
    }

    /**
     * @return ?Column<T>
     */
    public function get(string $name): ?Column
    {
        return $this->columns->get($name);
    }

    public function has(string $name): bool
    {
        return $this->columns->has($name);
    }

    /**
     * @return $this
     */
    public function visible(): self
    {
        return $this->visible ??= new self($this->columns->filter(fn(Column $c) => $c->isVisible()), $this->input, $this->defaultSort);
    }

    /**
     * @return $this
     */
    public function searchable(): self
    {
        return $this->searchable ??= new self($this->columns->filter(fn(Column $c) => $c->isSearchable()), $this->input, $this->defaultSort);
    }

    /**
     * @return $this
     */
    public function sortable(): self
    {
        return $this->sortable ??= new self($this->columns->filter(fn(Column $c) => $c->isSortable()), $this->input, $this->defaultSort);
    }

    public function sort(): ?OrderBy
    {
        if (!$sort = $this->input->sort()) {
            return $this->defaultSort;
        }

        return $this->sortable()->has($sort->field) ? $sort : $this->defaultSort;
    }

    /**
     * @return ArrayCollection<string,Column<T>>
     */
    public function all(): ArrayCollection
    {
        return $this->columns;
    }

    public function getIterator(): \Traversable
    {
        return $this->columns;
    }

    public function count(): int
    {
        return $this->columns->count();
    }
}
