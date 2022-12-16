<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\Specification\Interpreter;

use Zenstruck\Collection\Doctrine\Specification\Context;
use Zenstruck\Collection\Specification\Interpreter;
use Zenstruck\Collection\Specification\Interpreter\SplitSupports;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class DoctrineInterpreter implements Interpreter
{
    use SplitSupports;

    protected function supportsContext(mixed $context): bool
    {
        return $context instanceof Context;
    }
}
