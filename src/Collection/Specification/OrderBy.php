<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Specification;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class OrderBy extends Field
{
    public const ASC = 'ASC';
    public const DESC = 'DESC';

    private string $direction;

    private function __construct(string $field, string $direction)
    {
        parent::__construct($field);

        $this->direction = $direction;
    }

    public function __toString(): string
    {
        return \sprintf('OrderBy%s(%s)', $this->direction(), $this->field());
    }

    public static function asc(string $field): self
    {
        return new self($field, self::ASC);
    }

    public static function desc(string $field): self
    {
        return new self($field, self::DESC);
    }

    public function direction(): string
    {
        return $this->direction;
    }
}
