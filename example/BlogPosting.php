<?php


require __DIR__ . "/assets/config.php";
require dirname(__DIR__, 1) . "/vendor/autoload.php";


use ElePHPant\StructuredData\WebPage;
use ElePHPant\StructuredData\BlogPosting;


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

/**
 * SINGLE POST EXAMPLE
 */
$post = new \stdClass();
$post->title = "It's not who I am underneath but what I do that defines me.";
$post->slug = "it-s-not-who-i-am-underneath-but-what-i-do-that-defines-me";
$post->subtitle = "Bruce Wayne, eccentric billionaire. No guns, no killing. Swear to me! I'm Batman";
$post->content = "<h3>I'm Batman</h3><p>Bats frighten me.</p><p>It's time my enemies shared my dread.</p>";
$post->post_date = "2020-12-30";
$post->post_modified = "2020-12-31";
$post->cover = "images/2020/12/it-s-not-who-i-am-underneath-but-what-i-do-that-defines-me.jpg";

/**
 * Schema: BlogPosting
 * @see https://schema.org/BlogPosting
 */
$blogPosting = new BlogPosting($webPage);
$blogPosting->start($post->title, $post->subtitle, $post->content, $post->post_date, $post->post_modified);
$blogPosting->image("https://www.yourdomain.com/storage/{$post->cover}");
$blogPosting->mainEntityOfPage("https://www.yourdomain.com/blog/{$post->slug}");
$blogPosting->publisher('https://www.yourdomain.com/logo.png');
$blogPosting->author('Bruce Wayne', 'https://gravatar.com/avatar', [
    'https://www.facebook.com/zuck',
    'https://www.instagram.com/zuck'
]);

?>

<h2>BlogPosting</h2>
<?= $blogPosting->render(); ?>
