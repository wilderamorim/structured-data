<?php
require __DIR__ . "/assets/config.php";
require __DIR__ . "/../vendor/autoload.php";

use \WilderAmorim\StructuredData\BlogPosting;

$blog = new BlogPosting("UEBI");
$blog->insertHeader("HeadLine", "Descrição", "Lorem Ipsum sit amet solor...", "2019-02-03 20:00:00")
    ->mainEntityOfPage("https://www.google.com.br")
    ->author("Wilder Amorim", "https://i.picsum.photos/id/171/600/600.jpg",
        ['https://www.facebook.com.br', 'https://www.google.com.br'])
    ->image("https://i.picsum.photos/id/171/600/600.jpg")
    ->publisher("UEBI", "https://i.picsum.photos/id/171/600/600.jpg",
        ['https://www.facebook.com.br', 'https://www.google.com.br']);


echo $blog->structuredData();


if ($blog) {
    $blog->debug();
}

