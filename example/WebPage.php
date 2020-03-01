<?php


require __DIR__ . "/assets/config.php";
require dirname(__DIR__, 1) . "/vendor/autoload.php";


use WilderAmorim\StructuredData\WebPage;


/**
 * Schema: WebPage
 * @see https://schema.org/WebPage
 */
$webPage = new WebPage();
$webPage->start(
    'Wayne Enterprises, Inc.',
    'Wayne Enterprises is a big, growing multinational company',
    'https://www.yourdomain.com/wayne-enterprises.jpg',
    'https://www.dccomics.com',
    'en-US'
);
$webPage->isPartOf(
    'https://www.yourdomain.com/logo.png',
    'https://www.yourdomain.com/logo.png'
);
$webPage->about(
    'https://www.yourdomain.com/logo.png'
);
$webPage->creator(
    'https://www.yourdomain.com/logo.png',
    'Gotham City',
    'DC',
    '12345-678',
    '1007 Mountain Drive',
    'Bruce Wayne',
    'https://gravatar.com/avatar', [
        'https://www.facebook.com/zuck',
        'https://www.instagram.com/zuck'
    ]
);

?>

<h2>WebPage</h2>
<?= $webPage->render(); ?>
