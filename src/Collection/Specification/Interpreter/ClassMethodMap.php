<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Specification\Interpreter;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
trait ClassMethodMap
{
    protected static function classInMap(mixed $specification): bool
    {
        if (!\is_object($specification)) {
            return false;
        }

        return \array_key_exists($specification::class, static::classMethodMap());
    }

    protected static function methodFor(object $specification): string
    {
        return static::classMethodMap()[$specification::class];
    }

    /**
     * @return array<class-string, string>
     */
    abstract protected static function classMethodMap(): array;

    protected function supportsSpecification(mixed $specification): bool
    {
        return self::classInMap($specification);
    }
}
