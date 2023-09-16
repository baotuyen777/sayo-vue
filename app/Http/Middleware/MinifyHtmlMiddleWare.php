<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MinifyHtmlMiddleWare
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($response instanceof Response && $response->isSuccessful() && $response->headers->get('content-type') === 'text/html; charset=UTF-8') {
            $output = $response->getContent();
            $output = $this->minifyHtml($output);
            $response->setContent($output);
        }

        return $response;
    }

    protected function minifyHtml($html)
    {
        // Minification logic here
        $search = [
            '/\>[^\S ]+/s',  // Remove white space after tags
            '/[^\S ]+\</s',  // Remove white space before tags
            '/(\s)+/s',      // Remove multiple spaces
        ];

        $replace = [
            '>',
            '<',
            '\\1',
        ];

        return preg_replace($search, $replace, $html);
    }
}
