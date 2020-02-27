# Structured Data Library Test

[![Maintainer](http://img.shields.io/badge/maintainer-@WilderAmorim-blue.svg?style=flat-square)](https://twitter.com/WilderAmorim)
[![Source Code](http://img.shields.io/badge/source-WilderAmorim/structured-data-blue.svg?style=flat-square)](https://github.com/WilderAmorim/structured-data)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/WilderAmorim/structured-data.svg?style=flat-square)](https://packagist.org/packages/WilderAmorim/structured-data)
[![Latest Version](https://img.shields.io/github/release/WilderAmorim/structured-data.svg?style=flat-square)](https://github.com/WilderAmorim/structured-data/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/WilderAmorim/structured-data.svg?style=flat-square)](https://scrutinizer-ci.com/g/WilderAmorim/structured-data)
[![Quality Score](https://img.shields.io/scrutinizer/g/WilderAmorim/structured-data.svg?style=flat-square)](https://scrutinizer-ci.com/g/WilderAmorim/structured-data)
[![Total Downloads](https://img.shields.io/packagist/dt/WilderAmorim/structured-data.svg?style=flat-square)](https://packagist.org/packages/cWilderAmorim/structured-data)

###### Structured Data Library is a small set of classes developed in UpInside's Full Stack PHP Developer training for integration into the webservice of a SaaS platform developed in the course..

Structured Data Library é um pequeno conjunto de classes desenvolvidas na formação Full Stack PHP Developer da UpInside para integração ao webservice de uma plataforma SaaS desenvolvida no curso.

Você pode saber mais **[clicando aqui](https://www.upinside.com.br/fsphp)**.

### Highlights

- Simple installation (Instalação simples)
- Abstraction of all API methods (Abstração de todos os métodos da API)
- Easy authentication with login and password (Fácil autenticação com login e senha)
- Composer ready and PSR-2 compliant (Pronto para o composer e compatível com PSR-2)

## Installation

Structured Data is available via Composer:

```bash
"WilderAmorim/structured-data": "^1.0"
```

or run

```bash
composer require WilderAmorim/structured-data
```

## Documentation

###### For details on how to use, see a sample folder in the component directory. In it you will have an example of use for each class. It works like this:

Para mais detalhes sobre como usar, veja uma pasta de exemplo no diretório do componente. Nela terá um exemplo de uso para cada classe. Ele funciona assim:

#### User endpoint:

```php
<?php


require __DIR__ . "/../vendor/autoload.php";


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
```

## Contributing

Please see [CONTRIBUTING](https://github.com/WilderAmorim/structured-data/blob/master/CONTRIBUTING.md) for details.

## Support

###### Security: If you discover any security related issues, please email agencia@uebi.com.br instead of using the issue tracker.

Se você descobrir algum problema relacionado à segurança, envie um e-mail para agencia@uebi.com.br em vez de usar o rastreador de problemas.

Thank you

## Credits

- [Wilder Amorim](https://github.com/WilderAmorim) (Developer)
- [Sérgio Danilo Jr.](https://github.com/sergiodanilojr) (Developer)
- [Agência Uebi](https://www.uebi.com.br) (Team)
- [All Contributors](https://github.com/WilderAmorim/structured-data/contributors) (This Rock)

## License

The MIT License (MIT). Please see [License File](https://github.com/WilderAmorim/structured-data/blob/master/LICENSE) for more information.