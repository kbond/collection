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

use Zenstruck\Collection\Grid;
use Zenstruck\Collection\Grid\Definition\ActionDefinition;
use Zenstruck\Collection\Grid\Definition\ColumnDefinition;
use Zenstruck\Collection\Grid\Filter\AutoFilter;
use Zenstruck\Collection\Grid\Formatter\DateTimeFormatter;
use Zenstruck\Collection\Grid\Formatter\EmptyFormatter;
use Zenstruck\Collection\Grid\Handler\DefaultHandler;
use Zenstruck\Collection\Matchable;
use Zenstruck\Collection\Specification\OrderBy;

use function Zenstruck\collect;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template T of array<string,mixed>|object
 */
final class GridBuilder
{
    /** @var Matchable<mixed,T>|null */
    public ?Matchable $source = null;
    public ?Handler $handler = null;
    public ?OrderBy $defaultSort = null;
    public ?PerPage $perPage = null;
    public ?object $specification = null;
    public ?string $defaultAction = null;

    /** @var array<string,ColumnDefinition<T>> */
    private array $columns = [];

    /** @var array<string,ActionDefinition<T>> */
    private array $actions = [];

    /** @var array<string,Filter> */
    private array $filters = [];

    /** @var array<string,Formatter> */
    private array $defaultFormatters = [];

    public function __construct()
    {
        $this
            ->addDefaultFormatter(new DateTimeFormatter())
            ->addDefaultFormatter(new EmptyFormatter())
        ;
    }

    /**
     * @return Grid<T>
     */
    public function build(Input $input): Grid
    {
        $handler = $this->handler ?? new DefaultHandler();

        $columns = collect($this->columns)
            ->sortBy(fn(ColumnDefinition $column) => $column->weight)
            ->map(fn(ColumnDefinition $column) => new Column(
                definition: $column,
                input: $input,
                handler: $handler,
                formatters: [...$this->defaultFormatters, ...$column->formatters],
            ))
        ;

        $actions = collect($this->actions)
            ->sortBy(fn(ActionDefinition $action) => $action->weight)
            ->map(fn(ActionDefinition $action) => new Action(
                definition: $action,
                handler: $handler,
            ))
        ;

        return new Grid( // @phpstan-ignore-line
            input: $input,
            source: $this->source ?? throw new \LogicException('No source defined.'), // @phpstan-ignore-line
            columns: new Columns($columns, $input, $this->defaultSort), // @phpstan-ignore-line
            actions: new Actions($actions), // @phpstan-ignore-line
            filters: new Filters($this->filters),
            perPage: $this->perPage,
            specification: $this->specification,
        );
    }

    /**
     * @param bool|string|(object&callable():bool)   $visible
     * @param null|string|(object&callable(T):mixed) $accessor
     * @param OrderBy::*|null                        $defaultSort
     * @param Formatter[]|Formatter                  $formatters
     *
     * @return $this
     */
    public function addColumn(
        string $name,
        ?string $label = null,
        bool $searchable = false,
        bool $sortable = false,
        bool $autofilter = false,
        bool|string|callable $visible = true,
        ?int $weight = null,
        string|callable|null $accessor = null,
        ?string $defaultSort = null,
        Formatter|array $formatters = [],
    ): self {
        $this->columns[$name] = new ColumnDefinition( // @phpstan-ignore-line
            name: $name,
            label: $label,
            searchable: $searchable,
            sortable: $sortable,
            visible: \is_object($visible) && \is_callable($visible) ? $visible(...) : $visible,
            weight: $weight ?? (\count($this->columns) + 1) * 100,
            accessor: \is_object($accessor) && \is_callable($accessor) ? $accessor(...) : $accessor,
            formatters: \is_array($formatters) ? $formatters : [$formatters],
        );

        if ($defaultSort) {
            $this->defaultSort = new OrderBy($name, $defaultSort);
        }

        if ($autofilter) {
            $this->addFilter($name, new AutoFilter($name));
        }

        return $this;
    }

    /**
     * @return ColumnDefinition<T>
     */
    public function getColumn(string $name): ColumnDefinition
    {
        return $this->columns[$name] ?? throw new \InvalidArgumentException(\sprintf('Column "%s" does not exist.', $name));
    }

    /**
     * @return $this
     */
    public function addDefaultFormatter(Formatter $formatter): self
    {
        $this->defaultFormatters[$formatter::name()] = $formatter;

        return $this;
    }

    /**
     * @param array<string,mixed|(object&callable(T):mixed)> $parameters prefix values with "@" to access item properties
     * @param bool|string|(object&callable(T):bool)          $visible
     * @param null|string|(object&callable(T):string)        $url
     *
     * @return $this
     */
    public function addAction(
        string $name,
        ?string $route = null,
        array $parameters = [],
        bool|string|callable $visible = true,
        string|callable|null $url = null,
        ?string $label = null,
        ?int $weight = null,
    ): self {
        $this->actions[$name] = new ActionDefinition( // @phpstan-ignore-line
            name: $name,
            route: $route,
            parameters: $parameters,
            visible: \is_object($visible) && \is_callable($visible) ? $visible(...) : $visible,
            url: \is_object($url) && \is_callable($url) ? $url(...) : $url,
            label: $label,
            weight: $weight ?? (\count($this->actions) + 1) * 100,
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function addFilter(string $name, Filter $filter): self
    {
        $this->filters[$name] = $filter;

        return $this;
    }
}
