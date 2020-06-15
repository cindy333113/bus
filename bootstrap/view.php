<?php

function render($templateName, $data = []): string
{
    extract($data);

    include __DIR__ . "/../resources/views/{$templateName}.php";

    return ob_get_clean();
}
