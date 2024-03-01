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

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
interface Handler
{
    /**
     * @param array<string,mixed>|object $item
     */
    public function access(array|object $item, string $field): mixed;

    /**
     * @param array<string,mixed>|object|null $item
     */
    public function isGranted(string $attribute, array|object|null $item = null): bool;

    /**
     * @param array<string,mixed>|object $item
     * @param array<string,mixed>        $parameters
     */
    public function url(array|object $item, string $route, array $parameters = []): string;
}
