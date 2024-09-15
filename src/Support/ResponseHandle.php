<?php

namespace TallStackUi\EnvBar\Support;

use Symfony\Component\HttpFoundation\Response;

readonly class ResponseHandle
{
    public function __construct(private Render $render, private Response $response)
    {
        //
    }

    public function __invoke(): Response
    {
        $content = $this->response->getContent();

        if (($head = strpos($content, '<head>')) !== false) {
            $content = substr_replace($content, $this->render->css(), $head + 6, 0);
        }

        if (($start = strpos($content, '<body')) !== false) {
            $end = strpos($content, '>', $start);

            if ($end !== false) {
                $content = substr_replace($content, $this->render->component(), $end + 1, 0);
            }
        }

        return $this->response->setContent($content);
    }
}
