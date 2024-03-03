<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Specification;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class Field implements \Stringable
{
    public function __construct(public readonly string $field)
    {
    }

    public function __toString(): string
    {
        return \sprintf('%s(%s)', (new \ReflectionClass($this))->getShortName(), $this->field);
    }
}
