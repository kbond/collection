<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Grid\Definition;

use Zenstruck\Collection\Grid\Formatter;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template T of array<string,mixed>|object
 */
final class ColumnDefinition
{
    /**
     * @var array<string,Formatter>
     *
     * @internal
     */
    public array $formatters = [];

    /**
     * @param bool|string|\Closure():bool   $visible
     * @param null|string|\Closure(T):mixed $accessor
     * @param Formatter[]                   $formatters
     */
    public function __construct(
        public string $name,
        public ?string $label = null,
        public bool $searchable = false,
        public bool $sortable = false,
        public bool|string|\Closure $visible = true,
        public int $weight = 0,
        public string|\Closure|null $accessor = null,
        array $formatters = [],
    ) {
        foreach ($formatters as $formatter) {
            $this->addFormatter($formatter);
        }
    }

    /**
     * @return $this
     */
    public function addFormatter(Formatter $formatter): self
    {
        $this->formatters[$formatter::name()] = $formatter;

        return $this;
    }
}
