<?php

/*
 * This file is part of the zenstruck/collection package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Collection\Symfony;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Zenstruck\Collection\Doctrine\ObjectRepositoryFactory;
use Zenstruck\Collection\Doctrine\ORM\EntityRepositoryFactory;
use Zenstruck\Collection\Symfony\Doctrine\ChainObjectRepositoryFactory;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @codeCoverageIgnore
 */
final class ZenstruckCollectionBundle extends AbstractBundle
{
    /**
     * @param mixed[] $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if (!isset($builder->getParameter('kernel.bundles')['DoctrineBundle'])) {
            return;
        }

        $builder->register('.zenstruck_collection.doctrine.orm.object_repo_factory', EntityRepositoryFactory::class)
            ->addArgument(new Reference('doctrine'))
        ;

        $builder->register('.zenstruck_collection.doctrine.chain_object_repo_factory', ChainObjectRepositoryFactory::class)
            ->addArgument(new Reference('.zenstruck_collection.doctrine.orm.object_repo_factory'))
            ->addTag('kernel.reset', ['method' => 'reset'])
        ;

        $builder->setAlias(ObjectRepositoryFactory::class, '.zenstruck_collection.doctrine.chain_object_repo_factory');
    }
}
