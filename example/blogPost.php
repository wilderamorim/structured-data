<?php


require __DIR__ . "/assets/config.php";
require dirname(__DIR__, 1) . "/vendor/autoload.php";


use WilderAmorim\StructuredData\BlogPosting;
use WilderAmorim\StructuredData\InitialSchema;

//Constructor WEB
$initialSchema = new InitialSchema('Wayne Enterprises, Inc.', 'https://www.dccomics.com', ['NÃO testando rede social']);

var_dump($initialSchema);
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
$blogPosting = (new BlogPosting($initialSchema));

$blogPosting->start($post->title, $post->subtitle, $post->content, $post->post_date, $post->post_modified);
$blogPosting->image($post->cover);
$blogPosting->publisher($post->cover);
$blogPosting->author("Bruce Wayne", $post->cover);
$blogPosting->mainEntityOfPage($post->slug);

var_dump($blogPosting);

//json
echo $blogPosting->structuredData();

//debug
$blogPosting->debug();

echo "<br>";
echo "<hr>";
echo "<br>";

var_dump($blogPosting->data()->publisher->logo);

?>

<!--insert json-->
<script type="application/ld+json">
    <?= $blogPosting->structuredData(); ?>
</script>