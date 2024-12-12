<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switchLocale($locale, Request $request)
    {
        // Check if the locale is supported
        if (!in_array($locale, config('app.supported_locales'))) {
            return redirect()->back()->with('error', 'Unsupported locale.');
        }

        // Set the application locale
        App::setLocale($locale);

        // Store the selected locale in the session
        session()->put('locale', $locale);

        // If the new locale is the default locale, redirect to the previous URL

        // Get the current URL and replace the locale segment
        $previousUrl = url()->previous();
        $urlSegments = explode('/', parse_url($previousUrl, PHP_URL_PATH));

        // Assume the first segment is the locale
        if ($locale === config('app.locale')) {
            array_splice($urlSegments, 1, 1);
        } else {
            if (in_array($urlSegments[1], config('app.supported_locales'))) {
                $urlSegments[1] = $locale;
            } else {
                // If no locale exists in the URL, prepend it
                array_splice($urlSegments, 1, 0, $locale);
            }
        }

        // Rebuild the URL with the new locale
        $newUrl = implode('/', $urlSegments);

        return redirect($newUrl);
    }
}
