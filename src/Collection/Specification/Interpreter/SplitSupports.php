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
trait SplitSupports
{
    public function supports(mixed $specification, mixed $context): bool
    {
        return $this->supportsSpecification($specification) && $this->supportsContext($context);
    }

    abstract protected function supportsSpecification(mixed $specification): bool;

    abstract protected function supportsContext(mixed $context): bool;
}
