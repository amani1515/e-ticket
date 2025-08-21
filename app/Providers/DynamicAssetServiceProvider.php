<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class DynamicAssetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Force asset URLs to use current request host and scheme
        if ($this->app->runningInConsole() === false) {
            $request = request();
            if ($request) {
                $scheme = $request->isSecure() ? 'https' : 'http';
                $host = $request->getHost();
                $port = $request->getPort();
                
                // Build dynamic URL
                $url = $scheme . '://' . $host;
                if (($scheme === 'http' && $port !== 80) || ($scheme === 'https' && $port !== 443)) {
                    $url .= ':' . $port;
                }
                
                URL::forceRootUrl($url);
                config(['app.url' => $url]);
            }
        }
    }
}