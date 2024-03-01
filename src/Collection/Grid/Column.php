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

use Zenstruck\Collection\Grid\Definition\ColumnDefinition;
use Zenstruck\Collection\Specification\OrderBy;

use function Symfony\Component\String\u;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template T of array<string,mixed>|object
 */
final class Column
{
    private bool $visible;

    /**
     * @param ColumnDefinition<T>     $definition
     * @param array<string,Formatter> $formatters
     *
     * @internal
     */
    public function __construct(
        private ColumnDefinition $definition,
        private Input $input,
        private Handler $handler,
        private array $formatters,
    ) {
    }

    public function name(): string
    {
        return $this->definition->name;
    }

    public function label(): ?string
    {
        return $this->definition->label;
    }

    public function isSearchable(): bool
    {
        return $this->definition->searchable;
    }

    public function isSortable(): bool
    {
        return $this->definition->sortable;
    }

    /**
     * @param T $item
     */
    public function value(array|object $item): mixed
    {
        if ($this->definition->accessor instanceof \Closure) {
            return ($this->definition->accessor)($item);
        }

        return $this->handler->access($item, $this->definition->accessor ?? $this->name());
    }

    /**
     * @param T $item
     */
    public function format(array|object $item): string
    {
        $value = $this->value($item);

        foreach ($this->formatters as $formatter) {
            if ($formatter->supports($value)) {
                return $formatter->format($value);
            }
        }

        if (!\is_scalar($value) && null !== $value && !$value instanceof \Stringable) {
            throw new \RuntimeException(\sprintf('Cannot format non-scalar value "%s" for column "%s".', \get_debug_type($value), $this->name()));
        }

        return (string) $value;
    }

    public function isVisible(): bool
    {
        return $this->visible ??= match (true) { // @phpstan-ignore-line
            \is_bool($this->definition->visible) => $this->definition->visible,
            $this->definition->visible instanceof \Closure => ($this->definition->visible)(),
            \is_string($this->definition->visible) => $this->handler->isGranted($this->definition->visible),
        };
    }

    public function humanize(): string
    {
        return $this->label() ?? u($this->name())->snake()->replace('_', ' ')->title(allWords: true)->toString();
    }

    public function sort(): ?OrderBy
    {
        if (!($sort = $this->input->sort()) || $this->name() !== $sort->field) {
            return null;
        }

        return $sort;
    }

    public function applyAscSort(): Input
    {
        return $this->input->applySort(OrderBy::asc($this->name()));
    }

    public function applyDescSort(): Input
    {
        return $this->input->applySort(OrderBy::desc($this->name()));
    }

    public function applyOppositeSort(): Input
    {
        if (!$sort = $this->sort()) {
            return $this->applyAscSort();
        }

        return $this->input->applySort($sort->opposite());
    }
}
