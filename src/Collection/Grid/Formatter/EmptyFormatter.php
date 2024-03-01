<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Grid\Formatter;

use Zenstruck\Collection\Grid\Formatter;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class EmptyFormatter implements Formatter
{
    public function __construct(private string $default = '-')
    {
    }

    public static function name(): string
    {
        return 'empty';
    }

    public function format(mixed $value): string
    {
        return $this->default;
    }

    public function supports(mixed $value): bool
    {
        return empty($value);
    }
}
