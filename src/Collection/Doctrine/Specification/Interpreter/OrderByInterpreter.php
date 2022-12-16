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
use Zenstruck\Collection\Specification\OrderBy;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class OrderByInterpreter extends DoctrineInterpreter
{
    /**
     * @param OrderBy $specification
     * @param Context $context
     */
    public function interpret(mixed $specification, mixed $context): mixed
    {
        $context->qb()->addOrderBy($context->prefixAlias($specification->field()), $specification->direction());

        return null;
    }

    protected function supportsSpecification(mixed $specification): bool
    {
        return $specification instanceof OrderBy;
    }
}
