<?php
$html = [];
$html[] = '<ol>';
foreach (glob(__DIR__.'/example/*.php') as $examplePath) {
    $exampleSlug = basename($examplePath);
    $exampleSlug = preg_replace('/[^A-z0-9\-]/', '', $exampleSlug);
    $exampleSlug = substr($exampleSlug, 0, -3);
    $exampleName = ucwords(str_replace('-', ' ', $exampleSlug));
    $html[] = '<li>';
    $html[]     = '<a href  ="index.php';
    $html[]     = '?'.http_build_query(['example' => $exampleSlug]);
    $html[]     = '">';
    $html[]     = $exampleName;
    $html[]     = '</a>';
    $html[] = '</li>';
}
$html[] = '<ol>';
echo implode($html);
