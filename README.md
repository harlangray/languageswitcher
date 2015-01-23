languageswitcher
================
Component for Yii2 language switcher

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist "harlangray/languageswitcher": "*"
```

or add

```
"harlangray/languageswitcher": "*"
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
            'class' => 'harlangray\language\Language',
            'queryParam' => 'lang',
    
        ],
        // ...
    ],
    ...
];
```

You must define available languages in `Yii::$app->params['languages']` as code => language in the config/params.php

'languages' => [
    'en' => 'english',
    'si' => 'සිංහල',
    'ta' => 'தமிழ்'
] 


and use

```
Yii::$app->lang->getMenuItems()
```
In your menu "items"

EX:
echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ........
                    .........
                    ........
                    Yii::$app->lang->getMenuItems()
                    ],                
            ]);
            NavBar::end();
            
