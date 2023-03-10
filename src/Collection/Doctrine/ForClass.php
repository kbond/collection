<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @readonly
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class ForClass
{
    /**
     * @param class-string $name
     */
    public function __construct(public string $name)
    {
    }
}
