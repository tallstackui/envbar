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

        if ($content === false) {
            return $this->response;
        }

        if (($head = strpos($content, '<head>')) !== false) {
            $content = substr_replace($content, $this->render->css(), $head + 6, 0); // @phpstan-ignore-line
            $content = substr_replace($content, $this->render->js(), $head + 6, 0); // @phpstan-ignore-line
        }

        $pattern = '/<body\b(?:[^"\'<>]*|"(?:[^"\\\\]|\\\\.)*"|\'(?:[^\'\\\\]|\\\\.)*\')*>/i';

        $content = preg_replace_callback(
            $pattern,
            fn (array $matches) => $matches[0].PHP_EOL.$this->render->component(), // @phpstan-ignore-line
            $content,
            1
        );

        return $this->response->setContent($content);
    }
}
