<?php

/* Global helper functions */
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if (!function_exists('base_path'))
{
    function base_path($path = '')
    {
        return  __DIR__ . "/../{$path}";
    }
}

if (!function_exists('config_path'))
{
    function config_path($path = '')
    {
        return base_path("config/{$path}");
    }
}

if (!function_exists('app_path'))
{
    function app_path($path = '')
    {
        return base_path("app/{$path}");
    }
}

if (!function_exists('database_path'))
{
    function database_path($path = '')
    {
        return base_path("database/{$path}");
    }
}

if (!function_exists('throw_when'))
{
    function throw_when(bool $fails, string $message, string $exception = Exception::class)
    {
        if (!$fails) return;

        throw new $exception($message);
    }
}

if (!function_exists('config'))
{
    function config($path = null)
    {
        $config = [];
        $folder = scandir(config_path());
        $config_files = array_slice($folder, 2, count($folder));

        foreach ($config_files as $file)
        {
            throw_when(
                Str::after($file, '.') !== 'php',
                'Config files must be .php files'
            );
            data_set($config, Str::before($file, '.php') , require config_path($file));
        }

        return data_get($config, $path);
    }
}

if (!function_exists('data_get')) {
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed  $target
     * @param  string|array|int|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        while (! is_null($segment = array_shift($key))) {
            if ($segment === '*') {
                if ($target instanceof Collection) {
                    $target = $target->all();
                } elseif (! is_array($target)) {
                    return value($default);
                }

                $result = [];

                foreach ($target as $item) {
                    $result[] = data_get($item, $key);
                }

                return in_array('*', $key) ? Arr::collapse($result) : $result;
            }

            if (Arr::accessible($target) && Arr::exists($target, $segment)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return value($default);
            }
        }

        return $target;
    }
}

if (!function_exists('data_set')) {
    /**
     * Set an item on an array or object using dot notation.
     *
     * @param  mixed  $target
     * @param  string|array  $key
     * @param  mixed  $value
     * @param  bool  $overwrite
     * @return mixed
     */
    function data_set(&$target, $key, $value, $overwrite = true)
    {
        $segments = is_array($key) ? $key : explode('.', $key);

        if (($segment = array_shift($segments)) === '*') {
            if (! Arr::accessible($target)) {
                $target = [];
            }

            if ($segments) {
                foreach ($target as &$inner) {
                    data_set($inner, $segments, $value, $overwrite);
                }
            } elseif ($overwrite) {
                foreach ($target as &$inner) {
                    $inner = $value;
                }
            }
        } elseif (Arr::accessible($target)) {
            if ($segments) {
                if (! Arr::exists($target, $segment)) {
                    $target[$segment] = [];
                }

                data_set($target[$segment], $segments, $value, $overwrite);
            } elseif ($overwrite || ! Arr::exists($target, $segment)) {
                $target[$segment] = $value;
            }
        } elseif (is_object($target)) {
            if ($segments) {
                if (! isset($target->{$segment})) {
                    $target->{$segment} = [];
                }

                data_set($target->{$segment}, $segments, $value, $overwrite);
            } elseif ($overwrite || ! isset($target->{$segment})) {
                $target->{$segment} = $value;
            }
        } else {
            $target = [];

            if ($segments) {
                data_set($target[$segment], $segments, $value, $overwrite);
            } elseif ($overwrite) {
                $target[$segment] = $value;
            }
        }

        return $target;
    }
}

if (!function_exists('csrf_html'))
{
    function csrf_html($csrf) {
        $html = '';
        foreach($csrf as $key => $value)
        {
            $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        }
        echo $html;
    };
}

if (!function_exists('pagination'))
{
    function pagination(object $obj): void
    {
        $html = '';
        $items = $obj->linkCollection();
        if (count($items) > 3)
        {
            $html .= '<ul class="pagination">';
            foreach ($items as $item)
            {
                $label = $item['label'];
                if ($item['label'] === 'Previous') $label = 'Назад';
                if ($item['label'] === 'Next') $label = 'Вперед';
                $liClass = 'page-item';
                if ($item['active']) $liClass .= ' active';
                if (!$item['url']) $liClass .= ' disabled';
                $html .= '<li class="'.$liClass.'">';
                $html .= '<a class="page-link" href="'.$item['url'].'">'.$label.'</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        echo $html;
    };
}