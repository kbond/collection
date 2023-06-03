<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests;

use PHPUnit\Framework\TestCase;

use function Zenstruck\collect;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class FunctionsTest extends TestCase
{
    /**
     * @test
     */
    public function collect(): void
    {
        $this->assertSame(['foo'], collect(['foo'])->eager()->all());
        $this->assertSame([], collect()->eager()->all());
        $this->assertSame([], collect(null)->eager()->all());
    }
}
