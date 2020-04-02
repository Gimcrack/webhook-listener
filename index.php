<?php

require_once "helpers.php";

$post = getPost();
$attributes = getKey($post, 'attributes');

$payload = [];

foreach($attributes as $key => $value)
{
    $payload[] = "{$key} = {$value}";
}

sendMail($_GET['email'], implode("\n",$payload));


