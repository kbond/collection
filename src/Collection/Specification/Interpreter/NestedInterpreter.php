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

use Zenstruck\Collection\Specification\Interpreter;
use Zenstruck\Collection\Specification\Nested;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class NestedInterpreter implements Interpreter, InterpreterAware
{
    use HasInterpreter;

    /**
     * @param Nested $specification
     */
    public function interpret($specification, mixed $context): mixed
    {
        return $this->interpreter()->interpret($specification->child(), $context);
    }

    public function supports(mixed $specification, mixed $context): bool
    {
        return $specification instanceof Nested;
    }
}
