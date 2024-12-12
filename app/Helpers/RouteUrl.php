<?php

if (!function_exists('route_url')) {
    /**
     * Generate a relative route URL without the domain, including the locale.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @return string
     */
    function route_url($name, $parameters = [], $absolute = true)
    {
        // Ensure the locale is included in the parameters if not already present
        $locale = app()->getLocale();
        $parameters = array_merge(['locale' => $locale], $parameters);

        // Get the full route URL (absolute)
        $url = route($name, $parameters, $absolute);
        
        // Strip the domain part to make it relative
        return str_replace(url('/'), '', $url);
    }
}
