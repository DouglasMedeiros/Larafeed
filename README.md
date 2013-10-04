Larafeed
========
[![Total Downloads](https://poser.pugx.org/dotzecker/larafeed/downloads.png)](https://packagist.org/packages/dotzecker/larafeed)

Feed (Atom and RSS) generator for Laravel 4


## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `dotzecker/larafeed`.

    "require": {
        "laravel/framework": "4.0.*",
        "dotzecker/larafeed": "dev-master"
    },

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the next step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'DotZecker\Larafeed\LarafeedServiceProvider'

Finally, you have to add the alias in the aliases array.

    'Feed' => 'DotZecker\Larafeed\Facades\Larafeed'


## Usage
It is very intuitive of use:
```php
$feed = Feed::make('atom', array(
    'link'  => URL::to('/'),
    'logo'  => asset('images/logo.png'),
    'icon'  => asset('favicon.ico'),
    'description' => "I'm super awesome and I like to code, do you?"
));
```

Or, if you prefer, you can fill attribute by attribute:
```php
$feed = Feed::make('atom');
$feed->link = URL::to('/');
$feed->description = "I don't say 'Hello World', the World says 'Hello Rafa' to me!";
```

You can add authors only with the name or with more info
```php
// Only with the name
$feed->addAuthor('Rafael Antonio');

// With full info
$feed->addAuthor(array('name' => 'Rafael', 'email' => 'mail@provider.foo', 'uri' => 'http://rafa.im'));
```

Surely this part, in your application, will be inside of a loop.
You can add the entry by this way:
```php
$feed->addEntry(array(
    'title'   => 'Mi primer post',
    'link'    => URL::to('/mi-primer-post'),
    'author'  => 'Rafael Antonio Gómez Casas',
    'pubDate' => '2013-03-15',
    'content' => 'Hola, este es mi primer post, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil, quos, reprehenderit, nemo minus consectetur ipsum molestias cumque voluptatum deserunt impedit totam ab aspernatur rem voluptatibus dolore optio distinctio sequi vero harum neque qui suscipit libero deleniti minima repellat recusandae delectus beatae dignissimos corporis quaerat et nesciunt inventore architecto voluptates voluptatem.'
));
```

Or you can fill it attribute by attribute:
```php
$entry = $feed->entry();
$entry->title = 'My super title';
$entry->content = '¿Qué tal? :P Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, aperiam!';
// ...
$feed->setEntry($entry); // We "inject" the entry
```

Finally, we return the generated feed
```php
return $feed->render();
```

## Credits

This package is inspired by [laravel4-feed](http://roumen.it/projects/laravel4-feed).


## License

Larafeed is licenced under the MIT license.
