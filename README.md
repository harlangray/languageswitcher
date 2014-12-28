yii2-language-switcher
======================
Component for Yii2 language switcher

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pvlg/yii2-language-switcher "*"
```

or add

```
"pvlg/yii2-language-switcher": "*"
```

to the require section of your `composer.json` file.


Usage
-----
Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    'bootstrap' => ['lang'],
    'components' => [
        'lang' => [
            'class' => 'pvlg\language\Language',
            //'cookieParams' => [
            //    'path' => '/',
            //    'domain' => '.example.com',
            //    // ...
            //],
            'queryParam' => 'lang',
            // ...
        ],
        // ...
    ],
    ...
];
```

You must define available languages in `Yii::$app->params['languages']` as code => language

```php
'languages' => [
    'en' => 'english',
    'ru' => 'russian',
]
```

and use

```
http://example.com/?lang=russian
```