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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table(name: 'relations')]
class Relation
{
    public const TABLE = 'relations';

    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    public ?int $id;

    #[ORM\Column]
    public int $value;

    #[ORM\OneToMany(mappedBy: 'relation', targetEntity: Entity::class, fetch: 'EXTRA_LAZY')]
    private Collection $entities;

    public function __construct(int $value, ?int $id = null)
    {
        $this->id = $id;
        $this->value = $value;
        $this->entities = new ArrayCollection();
    }

    public function getEntities(): Collection
    {
        return $this->entities;
    }
}
