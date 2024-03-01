<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zenstruck\Collection\Symfony\Grid\GridFactory;
use Zenstruck\Collection\Symfony\Grid\SymfonyHandler;

return static function(ContainerConfigurator $configurator) {
    $configurator->services()
        ->set('.zenstruck_collection.grid_handler', SymfonyHandler::class)
            ->args([
                service('property_accessor')->nullOnInvalid(),
                service('security.authorization_checker')->nullOnInvalid(),
                service('router')->nullOnInvalid(),
            ])

        ->set('.zenstruck_collection.grid_factory', GridFactory::class)
            ->args([
                tagged_locator('zenstruck_collection.grid_definition', indexAttribute: 'key'),
                service('.zenstruck_collection.grid_handler'),
            ])

        ->alias(GridFactory::class, '.zenstruck_collection.grid_factory')
    ;
};
