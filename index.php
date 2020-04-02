<?php

function getPost()
{
    if(!empty($_POST))
    {
        // when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request
        // NOTE: if this is the case and $_POST is empty, check the variables_order in php.ini! - it must contain the letter P
        return $_POST;
    }

    // when using application/json as the HTTP Content-Type in the request
    $post = json_decode(file_get_contents('php://input'), true);
    if(json_last_error() == JSON_ERROR_NONE)
    {
        return $post;
    }

    return [];
}

$post = getPost();

if ( is_array($post) )
{
    echo "<pre>";
    var_dump($post);
    echo "</pre>";
}



//$file = fopen("output.txt", "w");
//
//foreach ($_POST['feature']['attributes'] as $key => $var) {
//    fwrite($file, "{$key}=>{$var}");
//}
//
//fclose($file);