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

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template T of array<string,mixed>|object
 */
final class ActionDefinition
{
    /**
     * @param array<string,mixed|(object&callable(T):mixed)> $parameters
     * @param bool|string|\Closure(T):bool                   $visible
     * @param null|string|\Closure(T):string                 $url
     */
    public function __construct(
        public string $name,
        public ?string $route = null,
        public array $parameters = [],
        public bool|string|\Closure $visible = true,
        public string|\Closure|null $url = null,
        public ?string $label = null,
        public int $weight = 0,
    ) {
    }
}
