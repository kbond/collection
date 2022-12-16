<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Specification\Filter;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class ArrayComparison extends Comparison
{
    /**
     * @param mixed[] $value
     */
    final public function __construct(string $field, array $value)
    {
        parent::__construct($field, $value);
    }

    /**
     * @return mixed[]
     */
    final public function value(): array
    {
        return parent::value();
    }
}
