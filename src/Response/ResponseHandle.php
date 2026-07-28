<?php

namespace TallStackUi\EnvBar\Response;

use Symfony\Component\HttpFoundation\Response;

class ResponseHandle
{
    /** Matches an opening tag while tolerating quoted attribute values holding angle brackets. */
    private const TAG = '/<%s\b(?:[^"\'<>]*|"(?:[^"\\\\]|\\\\.)*"|\'(?:[^\'\\\\]|\\\\.)*\')*>/i';

    public function __construct(private readonly Render $render, private readonly Response $response)
    {
        //
    }

    /**
     * Inject all contents related to the EnvBar.
     */
    public function __invoke(): Response
    {
        if (! $this->html()) {
            return $this->response;
        }

        $content = $this->response->getContent();

        if ($content === false) {
            return $this->response;
        }

        return $this->response->setContent($this->component($this->assets($content)));
    }

    /**
     * Determine if the response carries HTML content.
     */
    private function html(): bool
    {
        return str_contains((string) $this->response->headers->get('Content-Type'), 'text/html');
    }

    /**
     * Inject the styles and scripts right after the opening head tag.
     */
    private function assets(string $content): string
    {
        if (preg_match(sprintf(self::TAG, 'head'), $content, $matches, PREG_OFFSET_CAPTURE) !== 1) {
            return $content;
        }

        [$tag, $position] = $matches[0];

        $assets = $this->render->css()->toHtml().$this->render->js()->toHtml();

        return substr_replace($content, $assets, $position + strlen($tag), 0);
    }

    /**
     * Inject the component on the @envbar placeholder, falling back to the opening body tag.
     */
    private function component(string $content): string
    {
        $component = $this->render->component()->render();

        if (str_contains($content, '@envbar')) {
            return str_replace('@envbar', $component, $content);
        }

        return (string) preg_replace_callback(
            sprintf(self::TAG, 'body'),
            fn (array $matches): string => $matches[0].PHP_EOL.$component,
            $content,
            1
        );
    }
}
