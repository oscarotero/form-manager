<?php

$menu_examples = [];
foreach (glob(__DIR__.'/example/*.php') as $examplePath) {
    $exampleSlug = basename($examplePath);
    $exampleSlug = preg_replace('/[^A-z0-9\-]/', '', $exampleSlug);
    $exampleSlug = substr($exampleSlug, 0, -3);
    $exampleName = ucwords(str_replace('-', ' ', $exampleSlug));

    $menu_examples[] = '<li>';
    $menu_examples[] = '<a href  ="index.php';
    $menu_examples[] = '?'.http_build_query(['example' => $exampleSlug]);
    $menu_examples[] = '">';
    $menu_examples[] = $exampleName;
    $menu_examples[] = '</a>';
    $menu_examples[] = '</li>';
}

return implode($menu_examples);
