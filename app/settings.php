<?php
use Psr\Container\ContainerInterface;

return function(ContainerInterface $container) {
    $container->set('settings', function() {
        return [
            'displayErrorDetails' => true,
            'logErrors' => true,
            'logErrorDetails' => true
        ];
    });
};
