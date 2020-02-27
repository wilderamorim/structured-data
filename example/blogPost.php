<?php


require __DIR__ . "/assets/config.php";
require dirname(__DIR__, 1) . "/vendor/autoload.php";


use WilderAmorim\StructuredData\BlogPosting;

/**
 * SINGLE POST EXAMPLE
 */
$post = new stdClass();
$post->title = "It's not who I am underneath but what I do that defines me.";
$post->slug = "it-s-not-who-i-am-underneath-but-what-i-do-that-defines-me";
$post->subtitle = "Bruce Wayne, eccentric billionaire. No guns, no killing. Swear to me! I'm Batman";
$post->content = "<p>No guns, no killing. Bruce Wayne, eccentric billionaire. Hero can be anyone. Even a man knowing something as simple and reassuring as putting a coat around a young boy shoulders to let him know the world hadn't ended.</p>
<p>Accomplice? I'm gonna tell them the whole thing was your idea. Someone like you. Someone who'll rattle the cages. I'll be standing where l belong. Between you and the peopIe of Gotham. It's not who I am underneath but what I do that defines me.</p>";
$post->post_date = "2020-12-30";
$post->post_modified = "2020-12-31";
$post->cover = "images/2020/12/it-s-not-who-i-am-underneath-but-what-i-do-that-defines-me.jpg";

/**
 * Schema: BlogPosting
 * @see https://schema.org/BlogPosting
 */
$blogPost = (new BlogPosting("Wayne Enterprises, Inc."))
    ->start($post->title, $post->subtitle, $post->content, $post->post_date, $post->post_modified)
    ->mainEntityOfPage("https://www.yourdomain.com/blog/{$post->slug}")
    ->author('Bruce Wayne', 'https://upload.wikimedia.org/wikipedia/pt/4/46/Bruce_Wayne_06.jpg', [
        'https://www.facebook.com/zuck',
        'https://www.instagram.com/zuck'
    ])
    ->publisher('https://www.yourdomain.com', 'https://www.yourdomain.com/logo.png', [
        'https://www.facebook.com/zuck',
        'https://www.instagram.com/zuck'
    ])
    ->image("https://www.yourdomain.com/storage/{$post->cover}");

//json
echo $blogPost->structuredData();

//debug
$blogPost->debug();

?>

<!--insert json-->
<script type="application/ld+json">
    <?= $blogPost->structuredData(); ?>
</script>