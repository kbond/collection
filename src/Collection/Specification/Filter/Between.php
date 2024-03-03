<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Specification\Filter;

use Zenstruck\Collection\Specification\Field;
use Zenstruck\Collection\Specification\Logic\AndX;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class Between extends Field
{
    public const INCLUSIVE = '[]';
    public const INCLUSIVE_BEGIN = '[)';
    public const INCLUSIVE_END = '(]';
    public const EXCLUSIVE = '()';
    public const EXCLUSIVE_BEGIN = '(]';
    public const EXCLUSIVE_END = '[)';

    /**
     * @param self::* $type
     */
    public function __construct(
        string $field,
        public readonly mixed $begin,
        public readonly mixed $end,
        public readonly string $type = self::INCLUSIVE,
    ) {
        parent::__construct($field);
    }

    public function __toString(): string
    {
        return \sprintf(
            'Between%s%s AND %s%s',
            $this->type[0],
            \is_scalar($this->begin) ? $this->begin : \get_debug_type($this->begin),
            \is_scalar($this->end) ? $this->end : \get_debug_type($this->end),
            $this->type[1],
        );
    }

    public static function inclusive(string $field, mixed $begin, mixed $end): self
    {
        return new self($field, $begin, $end, self::INCLUSIVE);
    }

    public static function exclusive(string $field, mixed $begin, mixed $end): self
    {
        return new self($field, $begin, $end, self::EXCLUSIVE);
    }

    public function asAnd(): AndX
    {
        return new AndX(
            '[' === $this->type[0] ? new GreaterThanOrEqualTo($this->field, $this->begin) : new GreaterThan($this->field, $this->begin),
            ']' === $this->type[1] ? new LessThanOrEqualTo($this->field, $this->end) : new LessThan($this->field, $this->end),
        );
    }
}
