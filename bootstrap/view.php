<?php

function render($templateName, $data = []): string
{
    extract($data);

    return include __DIR__ . "/../resources/views/{$templateName}.php";
}
