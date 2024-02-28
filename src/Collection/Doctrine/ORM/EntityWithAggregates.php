<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Doctrine\ORM;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template V of object
 *
 * @mixin V
 */
final class EntityWithAggregates
{
    /**
     * @param V                   $entity
     * @param array<string,mixed> $aggregates
     */
    private function __construct(private object $entity, private array $aggregates)
    {
    }

    /**
     * @param mixed[] $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (\method_exists($this->entity, $name)) {
            return $this->entity->{$name}(...$arguments);
        }

        return $this->aggregates[$name] ?? throw new \BadMethodCallException(\sprintf('"%s" is not a existing %s method or aggregate.', $name, $this->entity::class));
    }

    public function __get(string $name): mixed
    {
        return $this->entity->{$name} ?? $this->aggregates[$name] ?? throw new \LogicException(\sprintf('"%s" is not a existing %s property or aggregate.', $name, $this->entity::class));
    }

    public function __isset(string $name): bool
    {
        return isset($this->entity->{$name}) || isset($this->aggregates[$name]);
    }

    /**
     * @internal
     *
     * @param array{0:V} $data
     *
     * @return self<V>
     */
    public static function create(mixed $data): static
    {
        if (!\is_array($data) || !isset($data[0]) || !\is_object($data[0])) {
            throw new \LogicException(\sprintf('Results does not contain aggregate fields, do not call %s::withAggregates().', EntityResult::class));
        }

        $entity = $data[0];

        unset($data[0]);

        return new self($entity, $data);
    }

    /**
     * @return V
     */
    public function entity(): object
    {
        return $this->entity;
    }

    /**
     * @return array<string,mixed>
     */
    public function aggregates(): array
    {
        return $this->aggregates;
    }
}
