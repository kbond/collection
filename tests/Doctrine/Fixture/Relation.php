<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Tests\Doctrine\Fixture;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @Entity
 *
 * @Table(name="relations")
 */
class Relation
{
    public const TABLE = 'relations';

    /**
     * @Id
     *
     * @Column(type="integer")
     *
     * @GeneratedValue
     */
    public ?int $id;

    /**
     * @Column(type="string")
     */
    public int $value;

    public function __construct(int $value, ?int $id = null)
    {
        $this->id = $id;
        $this->value = $value;
    }
}
