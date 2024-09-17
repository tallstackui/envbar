<?php

namespace TallStackUi\EnvBar\Response;

use Symfony\Component\HttpFoundation\Response;

class ResponseHandle
{
    public function __construct(private readonly Render $render, private readonly Response $response)
    {
        //
    }

    /**
     * Inject all contents related to the EnvBar.
     */
    public function __invoke(): Response
    {
        $content = $this->response->getContent();

        if (($head = strpos($content, '<head>')) !== false) {
            $content = substr_replace($content, $this->render->css(), $head + 6, 0); // @phpstan-ignore-line
            $content = substr_replace($content, $this->render->js(), $head + 6, 0); // @phpstan-ignore-line
        }

        // Although this code is not the best, it was the only viable way found, at least for now,
        // to insert the envbar in the correct place, after <body>, for situations where we have things
        // like "x-on:redirect="setTimeout(() => window.location.href = $event.detail.route, $event.detail.time ?? 3000)">"
        // inside the <body>, things with symbols that mess up regex.
        $explode = array_map(function (string $line): string {
            if (str_contains($line, '<body')) {
                return $line.$this->render->component(); // @phpstan-ignore-line
            }

            return $line;
        }, explode("\n", $content));

        return $this->response->setContent(implode("\n", $explode));
    }
}
