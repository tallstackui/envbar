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

        if (($start = strpos($content, '<body')) !== false) {
            $end = strpos($content, '">', $start);

            if ($end !== false) {
                $content = substr_replace($content, $this->render->component(), $end + 3, 0);
            } else {
                $end = strpos($content, '>', $start);

                if ($end !== false) {
                    $content = substr_replace($content, $this->render->component(), $end + 2, 0);
                }
            }
        }

        return $this->response->setContent($content);
    }
}
