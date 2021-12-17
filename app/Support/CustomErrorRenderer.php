<?php

declare(strict_types=1);

namespace App\Support;

use Slim\Error\AbstractErrorRenderer;
use Throwable;
use eftec\bladeone\BladeOne;

use function get_class;
use function htmlentities;
use function sprintf;

/**
 * Custom Slim application HTML Error Renderer
 */
class CustomErrorRenderer extends AbstractErrorRenderer
{
    /**
     * @param Throwable $exception
     * @param bool      $displayErrorDetails
     * @return string
     */
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        $code = $exception->getCode();
        $htmlException = null;
        if ($displayErrorDetails) {
            $htmlException = $this->renderExceptionFragment($exception);
        }
        $blade = new BladeOne(
            config('blade.views'),
            config('blade.cache'),
            config('blade.mode')
        );

        return $blade->run('error', compact('code', 'htmlException'));
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    private function renderExceptionFragment(Throwable $exception): string
    {
        $html = sprintf('<div><strong>Type:</strong> %s</div>', get_class($exception));

        $code = $exception->getCode();
        if ($code !== null) {
            $html .= sprintf('<div><strong>Code:</strong> %s</div>', $code);
        }

        $message = $exception->getMessage();
        if ($message !== null) {
            $html .= sprintf('<div><strong>Message:</strong> %s</div>', htmlentities($message));
        }

        $file = $exception->getFile();
        if ($file !== null) {
            $html .= sprintf('<div><strong>File:</strong> %s</div>', $file);
        }

        $line = $exception->getLine();
        if ($line !== null) {
            $html .= sprintf('<div><strong>Line:</strong> %s</div>', $line);
        }

        $trace = $exception->getTraceAsString();
        if ($trace !== null) {
            $html .= '<h2>Trace</h2>';
            $html .= sprintf('<pre>%s</pre>', htmlentities($trace));
        }

        return $html;
    }
}
