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
 * @Table(name="entities")
 */
class Entity
{
    public const TABLE = 'entities';

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
    public string $value;

    /**
     * @ManyToOne(targetEntity="Relation", cascade={"persist"})
     * @JoinColumn(name="relation_id", referencedColumnName="id", nullable=true)
     */
    public ?Relation $relation = null;

    public function __construct(string $value, ?int $id = null)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public static function withRelation(string $value, Relation $relation): self
    {
        $entity = new self($value);
        $entity->relation = $relation;

        return $entity;
    }
}
