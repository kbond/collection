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
final class DateTimeFormatter implements Formatter
{
    public function __construct(private string $format = 'Y-m-d H:i:s')
    {
    }

    public static function date(string $format = 'Y-m-d'): self
    {
        return new self($format);
    }

    public static function name(): string
    {
        return 'datetime';
    }

    /**
     * @param \DateTimeInterface $value
     */
    public function format(mixed $value): string
    {
        return $value->format($this->format);
    }

    public function supports(mixed $value): bool
    {
        return $value instanceof \DateTimeInterface;
    }
}
