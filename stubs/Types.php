<?php

use Zenstruck\Collection;
use Zenstruck\Collection\Repository\ObjectRepository;
use Zenstruck\Collection\Doctrine\ORM\EntityRepository;
use Zenstruck\Collection\LazyCollection;

use function PHPStan\Testing\assertType;
use function Zenstruck\collect;

assertType('Zenstruck\Collection\LazyCollection<int, User>', new LazyCollection([new User]));

/** @var ObjectRepository<User> $objectRepository */

assertType('Traversable<int, User>', $objectRepository->getIterator());
assertType('User|null', $objectRepository->find(1));
assertType('Zenstruck\Collection\Doctrine\Result<User>', $objectRepository->query([]));
assertType('array<int, User>', $objectRepository->query(null)->eager()->all());
assertType('User|null', $objectRepository->query(null)->first());
assertType('Zenstruck\Collection\Doctrine\Result<bool|float|int|string>', $objectRepository->query(null)->asScalar());
assertType('Zenstruck\Collection\Doctrine\Result<string>', $objectRepository->query(null)->asString());
assertType('Zenstruck\Collection\Doctrine\Result<int>', $objectRepository->query(null)->asInt());
assertType('Zenstruck\Collection\Doctrine\Result<float>', $objectRepository->query(null)->asFloat());
assertType('Zenstruck\Collection\Doctrine\Result<array<string, mixed>>', $objectRepository->query(null)->asArray());
assertType('Zenstruck\Collection\Doctrine\Result<int>', $objectRepository->query(null)->as(fn(): int => 1));
assertType('Zenstruck\Collection\Page<int, User>', $objectRepository->query(null)->paginate());

/** @var EntityRepository<User> $ormRepository */

assertType('Zenstruck\Collection\Doctrine\ORM\EntityResult<int>', $ormRepository->query(null)->as(fn(): int => 1));
assertType('Zenstruck\Collection\Doctrine\ORM\EntityResult<Zenstruck\Collection\Doctrine\ORM\EntityWithAggregates<User>>', $ormRepository->query(null)->withAggregates());

class User
{
}

assertType('Zenstruck\Collection<never, never>', collect());
assertType('Zenstruck\Collection<never, never>', collect());

/**
 * @param User[]|null $users
 * @return Collection<int, User>
 */
function get_users(array|null $users): Collection
{
    return collect($users);
}

assertType('Zenstruck\Collection<int, User>', get_users(null));
assertType('Zenstruck\Collection<int, User>', get_users([]));
assertType('Zenstruck\Collection<int, User>', get_users([new User()]));
assertType('Zenstruck\Collection<int, User>', get_users([new User()])->dump());
assertType('never', get_users([new User()])->dd());
