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

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class CallableInterpreter extends DoctrineInterpreter
{
    /**
     * @param callable $specification
     * @param Context  $context
     */
    public function interpret(mixed $specification, mixed $context): mixed
    {
        return $specification($context);
    }

    protected function supportsSpecification(mixed $specification): bool
    {
        return \is_callable($specification);
    }
}
