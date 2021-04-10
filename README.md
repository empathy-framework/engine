<p align="center"><img src="https://i.ibb.co/JFPn9PF/Logo-crop.png" width="256px" border="0"></p>

<h1 align="center"> 🚀 Empathy Engine</h1>

[![Latest Stable Version](https://poser.pugx.org/empathy-php/engine/v)](//packagist.org/packages/empathy-php/engine) [![Total Downloads](https://poser.pugx.org/empathy-php/engine/downloads)](//packagist.org/packages/empathy-php/engine) [![License](https://poser.pugx.org/empathy-php/engine/license)](//packagist.org/packages/empathy-php/engine)

**Empathy Engine** - фреймворк для реализации приложений на базе [Empathy Core](https://github.com/empathy-framework/core) или [Empathy Litecore](https://github.com/empathy-framework/litecore)

## Установка

```
composer require empathy-php/engine
```

Используется совместно с **Empathy Core** или **Empathy Litecore**

Для лучшей работы рекомендуется прописать следующий код в корневом файле `composer.json`:

```json
{
    "scripts": {
        "empathy-run": "vendor/empathy-php/core/empathy.exe vendor/empathy-php/core/script.php"
    }
}
```

После чего можно будет исполнять код

```
composer empathy-run
```

для запуска проекта

Код приложения можно писать в файле `app.php` в корневой директории проекта

## Пример работы:

app.php
```php
<?php

require 'vendor/autoload.php';

use Empathy\Engine\Components\{
    Form,
    Button
};

use function Empathy\Engine\Others\pre;

$form   = new Form;
$button = new Button ($form);

$form->caption = 'Example app';

$button->text = 'Click me!';
$button->bounds = [16, 16, 96, 32];

$button->on ('click', function ()
{
    pre ('Hello, World!');
});

$form->showDialog ();
```

Автор: [Подвирный Никита](https://vk.com/technomindlp)
