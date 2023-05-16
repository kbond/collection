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

use Doctrine\Common\Collections\AbstractLazyCollection;
use Zenstruck\Collection;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template K of array-key
 * @template V
 * @implements Collection<K,V>
 */
final class LazyCollection implements Collection
{
    /** @use IterableCollection<K,V> */
    use IterableCollection {
        take as private traitTake;
        first as private traitFirst;
    }

    /** @var iterable<K,V>|\Closure():iterable<K,V> */
    private \Closure|iterable $source;

    /**
     * @param null|iterable<K,V>|callable():iterable<K,V> $source
     */
    public function __construct(iterable|callable|null $source = null)
    {
        $source ??= [];

        if (\is_callable($source) && (!\is_iterable($source) || \is_array($source))) {
            $source = $source instanceof \Closure ? $source : \Closure::fromCallable($source);
        }

        $this->source = $source;
    }

    public function first(mixed $default = null): mixed
    {
        $source = &$this->normalizeSource();

        if ($source instanceof AbstractLazyCollection && !$source->isInitialized()) {
            return $source->slice(0, 1)[0] ?? $default;
        }

        return $this->traitFirst($default);
    }

    /**
     * @return self<K,V>
     */
    public function take(int $limit, int $offset = 0): self
    {
        $source = &$this->normalizeSource();

        if (\is_array($source)) {
            return new self(\array_slice($source, $offset, $limit, true));
        }

        if ($source instanceof AbstractLazyCollection && !$source->isInitialized()) {
            return new self($source->slice($offset, $limit));
        }

        return $this->traitTake($limit, $offset);
    }

    public function getIterator(): \Traversable
    {
        $source = &$this->normalizeSource();

        if ($source instanceof AbstractLazyCollection && !$source->isInitialized()) {
            foreach ($this->pages() as $page) {
                yield from $page;
            }

            return;
        }

        foreach ($source as $key => $value) {
            yield $key => $value;
        }
    }

    public function count(): int
    {
        if (\is_countable($source = &$this->normalizeSource())) {
            return \count($source);
        }

        return \iterator_count($source);
    }

    /**
     * @return iterable<K,V>
     */
    private function &normalizeSource(): iterable
    {
        if ($this->source instanceof \Generator) {
            throw new \InvalidArgumentException('$source must not be a generator directly as generators cannot be rewound. Try wrapping in a closure.');
        }

        if (\is_iterable($this->source)) {
            return $this->source;
        }

        // source is callback
        $source = ($this->source)();

        if ($source instanceof \Generator) {
            // generators cannot be rewound so don't set as $source (ensure callback is executed next time)
            return $source;
        }

        if (!\is_iterable($source)) {
            throw new \InvalidArgumentException('$source callback must return iterable.');
        }

        $this->source = $source;

        return $this->source;
    }

    /**
     * @return iterable<K,V>
     */
    private function iterableSource(): iterable
    {
        return \is_iterable($this->source) ? $this->source : ($this->source)();
    }
}
