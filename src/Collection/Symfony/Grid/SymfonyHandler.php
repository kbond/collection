<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Symfony\Grid;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Zenstruck\Collection\Grid\Handler\DefaultHandler;

use function Zenstruck\collect;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @internal
 */
final class SymfonyHandler extends DefaultHandler
{
    public function __construct(
        private ?PropertyAccessorInterface $accessor = null,
        private ?AuthorizationCheckerInterface $authorizationChecker = null,
        private ?UrlGeneratorInterface $urlGenerator = null,
    ) {
    }

    public function access(object|array $item, string $field): mixed
    {
        if ($this->accessor) {
            return $this->accessor->getValue($item, $field);
        }

        return parent::access($item, $field);
    }

    public function isGranted(string $attribute, object|array|null $item = null): bool
    {
        if ($this->authorizationChecker) {
            return $this->authorizationChecker->isGranted($attribute, $item);
        }

        return parent::isGranted($attribute, $item);
    }

    public function url(array|object $item, string $route, array $parameters = []): string
    {
        if (!$this->urlGenerator) {
            return parent::url($item, $route, $parameters);
        }

        $parameters = collect($parameters)
            ->map(function($value) use ($item) {
                if (\is_object($value) && \is_callable($value)) {
                    return $value($item);
                }

                if (\is_string($value) && \str_starts_with($value, '@')) {
                    return $this->access($item, \mb_substr($value, 1));
                }

                return $value;
            })
            ->all()
        ;

        return $this->urlGenerator->generate($route, $parameters);
    }
}
