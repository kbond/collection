<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Specification\Logic;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class Not extends Composite
{
    public function __construct(mixed $restriction)
    {
        parent::__construct($restriction);
    }
}
