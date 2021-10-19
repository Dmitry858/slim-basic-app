<?php
use Slim\App;

return function(App $app) {
    $app->addErrorMiddleware(
        config('middleware.error.displayErrorDetails'),
        config('middleware.error.logErrors'),
        config('middleware.error.logErrorDetails')
    );
};
