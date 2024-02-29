<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Symfony\Doctrine;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
#[\Attribute(\Attribute::TARGET_PARAMETER)]
final class ForObject extends Autowire
{
    public function __construct(
        /**
         * @var class-string $class
         */
        public readonly string $class,
    ) {
        parent::__construct(
            expression: \sprintf('service(".zenstruck_collection.doctrine.chain_object_repo_factory").create("%s")', \addslashes($this->class)),
        );
    }
}
