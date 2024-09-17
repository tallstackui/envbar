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
            $content = substr_replace($content, $this->render->css(), $head + 6, 0);
            $content = substr_replace($content, $this->render->js(), $head + 6, 0);
        }

        $content = preg_replace('/(<body[^>]*>)/i', '$1'.$this->render->component(), $content);

        return $this->response->setContent($content);
    }
}
