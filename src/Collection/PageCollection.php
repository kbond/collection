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
 * @template V
 * @implements \IteratorAggregate<int,Page<V>>
 */
final class PageCollection implements \IteratorAggregate, \Countable
{
    /** @var Collection<int,V> */
    private Collection $collection;
    private int $limit;

    /** @var Page<V> */
    private Page $page1;

    /**
     * @param Collection<int,V> $collection
     */
    public function __construct(Collection $collection, int $limit = Page::DEFAULT_LIMIT)
    {
        $this->collection = $collection;
        $this->limit = $limit;
    }

    /**
     * @return Page<V>
     */
    public function get(int $page): Page
    {
        return 1 === $page ? $this->page1() : new Page($this->collection, $page, $this->limit);
    }

    public function getIterator(): \Traversable
    {
        if (0 === $this->count()) {
            return;
        }

        yield $this->page1();

        for ($page = 2; $page <= $this->count(); ++$page) {
            yield $this->get($page);
        }
    }

    public function count(): int
    {
        if (0 === $this->page1()->count()) {
            return 0;
        }

        return $this->page1()->pageCount();
    }

    /**
     * @return Page<V>
     */
    private function page1(): Page
    {
        return $this->page1 ??= new Page($this->collection, 1, $this->limit);
    }
}
