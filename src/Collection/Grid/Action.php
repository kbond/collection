<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Grid;

use Zenstruck\Collection\Grid\Definition\ActionDefinition;

use function Symfony\Component\String\u;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @template T of array<string,mixed>|object
 */
final class Action
{
    private bool $visible;

    /**
     * @param ActionDefinition<T> $definition
     *
     * @internal
     */
    public function __construct(
        private ActionDefinition $definition,
        private Handler $handler,
    ) {
    }

    public function name(): string
    {
        return $this->definition->name;
    }

    public function label(): ?string
    {
        return $this->definition->label;
    }

    /**
     * @param T $item
     */
    public function isVisible(array|object $item): bool
    {
        return $this->visible ??= match (true) { // @phpstan-ignore-line
            \is_bool($this->definition->visible) => $this->definition->visible,
            $this->definition->visible instanceof \Closure => ($this->definition->visible)($item),
            \is_string($this->definition->visible) => $this->handler->isGranted($this->definition->visible, $item),
        };
    }

    /**
     * @param T $item
     */
    public function url(array|object $item): string
    {
        return match (true) {
            \is_string($this->definition->url) => $this->definition->url,
            $this->definition->url instanceof \Closure => ($this->definition->url)($item),
            \is_string($this->definition->route) => $this->handler->url($item, $this->definition->route, $this->definition->parameters),
            default => throw new \LogicException(\sprintf('No url or route defined for action "%s".', $this->name())),
        };
    }

    public function humanize(): string
    {
        return $this->label() ?? u($this->name())->snake()->replace('_', ' ')->title(allWords: true)->toString();
    }
}
