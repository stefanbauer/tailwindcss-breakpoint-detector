<?php

namespace StefanBauer\TailwindcssBreakpointDetector;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TailwindcssBreakpointDetector
{
    public function isEnabled(): bool
    {
        $this->app = resolve('app');
        $config = $this->app['config'];

        return $config->get('app.debug')
            && ! $this->app->runningInConsole()
            && ! $this->app->environment('testing');
    }

    protected function shouldHandleRequest(Request $request): bool
    {
        return ! $request->isXmlHttpRequest() && $request->acceptsHtml();
    }

    public function injectDetector(Request $request, Response $response)
    {
        if (! $this->shouldHandleRequest($request)) {
            return;
        }

        $content = $response->getContent();
        $detectorHtml = view('tailwindcss-breakpoint-detector::detector')->render();


        $position = strripos($content, '</body>');
        if ($position !== false) {
            $content = str_replace('</body>', $detectorHtml.'</body>', $content);
        } else {
            $content = $content.$detectorHtml;
        }

        $response->setContent($content);
    }
}
