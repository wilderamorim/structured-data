<?php


require __DIR__ . "/assets/config.php";
require dirname(__DIR__, 1) . "/vendor/autoload.php";


use WilderAmorim\StructuredData\Company;
use WilderAmorim\StructuredData\BlogPosting;

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
 * Start Company
 */
$company = new Company('Wayne Enterprises, Inc.', 'https://www.dccomics.com', [
    'https://www.facebook.com/facebook',
    'https://www.instagram.com/facebook'
]);

/**
 * Schema: BlogPosting
 * @see https://schema.org/BlogPosting
 */
$blogPosting = (new BlogPosting($company));
$blogPosting->start($post->title, $post->subtitle, $post->content, $post->post_date, $post->post_modified);
$blogPosting->image("https://www.yourdomain.com/storage/{$post->cover}");
$blogPosting->mainEntityOfPage("https://www.yourdomain.com/blog/{$post->slug}");
$blogPosting->publisher('https://www.yourdomain.com/logo.png');
$blogPosting->author('Bruce Wayne', 'https://gravatar.com/avatar', [
    'https://www.facebook.com/zuck',
    'https://www.instagram.com/zuck'
]);

//json render
echo $blogPosting->render();

//debug
$blogPosting->debug();

?>

<!--insert json-->
<script type="application/ld+json">
    <?= $blogPosting->render(); ?>
</script>