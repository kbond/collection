<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Grid\Handler;

use Zenstruck\Collection\Grid\Handler;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class DefaultHandler implements Handler
{
    public function access(object|array $item, string $field): mixed
    {
        if (\is_array($item) && \array_key_exists($field, $item)) {
            return $item[$field];
        }

        if (\is_object($item) && \property_exists($item, $field)) {
            return $item->{$field};
        }

        if (\is_object($item) && \method_exists($item, $field)) {
            return $item->{$field}();
        }

        throw new \RuntimeException(\sprintf('Cannot access field "%s" on value "%s".', $field, \get_debug_type($item)));
    }

    public function isGranted(string $attribute, object|array|null $item = null): bool
    {
        throw new \RuntimeException('No isGranted handler available.');
    }

    public function url(array|object $item, string $route, array $parameters = []): string
    {
        throw new \RuntimeException('No url handler available.');
    }
}
