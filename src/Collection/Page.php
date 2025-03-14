<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection;

use Zenstruck\Collection;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template K
 * @template V
 * @implements \IteratorAggregate<K,V>
 */
final class Page implements \IteratorAggregate, \Countable
{
    public const DEFAULT_LIMIT = 20;

    private int $page;
    private int $limit;
    private bool $strict = false;

    /** @var Collection<K,V> */
    private Collection $cachedPage;

    /**
     * @param Collection<K,V> $collection
     */
    public function __construct(private Collection $collection, int $page = 1, int $limit = self::DEFAULT_LIMIT)
    {
        $this->page = \max($page, 1);
        $this->limit = $limit < 1 ? self::DEFAULT_LIMIT : $limit;
    }

    /**
     * Enable/Disable "strict mode".
     *
     * When enabled, when calling {@see currentPage}, if provided page number
     * greater than the calculated last page number, the last page number will
     * be returned.
     *
     * When enabled, extra work (ie count query) may be required to ensure the
     * current page number is valid.
     *
     * @return $this
     */
    public function strict(bool $flag = true): self
    {
        $this->strict = $flag;

        return $this;
    }

    public function currentPage(): int
    {
        if (!$this->strict) {
            return $this->page;
        }

        $lastPage = $this->lastPage();

        if ($this->page > $lastPage) {
            return $lastPage;
        }

        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * @return int the count for the current page
     */
    public function count(): int
    {
        return $this->getPage()->count();
    }

    public function totalCount(): int
    {
        return $this->collection->count();
    }

    public function getIterator(): \Traversable
    {
        return $this->getPage()->getIterator();
    }

    public function nextPage(): ?int
    {
        $currentPage = $this->currentPage();

        if ($currentPage === $this->lastPage()) {
            return null;
        }

        return ++$currentPage;
    }

    public function previousPage(): ?int
    {
        $page = $this->currentPage();

        if (1 === $page) {
            return null;
        }

        return --$page;
    }

    public function firstPage(): int
    {
        return 1;
    }

    public function lastPage(): int
    {
        $totalCount = $this->totalCount();

        if (0 === $totalCount) {
            return 1;
        }

        return (int) \ceil($totalCount / $this->limit());
    }

    public function pageCount(): int
    {
        return $this->lastPage();
    }

    public function haveToPaginate(): bool
    {
        return $this->pageCount() > 1;
    }

    /**
     * @return Collection<K,V>
     */
    private function getPage(): Collection
    {
        if (isset($this->cachedPage)) {
            return $this->cachedPage;
        }

        $offset = $this->currentPage() * $this->limit() - $this->limit();

        return $this->cachedPage = $this->collection->take($this->limit(), $offset);
    }
}
