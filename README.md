Buuum - Event package for your app
=======================================

[![Packagist](https://poser.pugx.org/buuum/phevent/v/stable)](https://packagist.org/packages/buuum/phevent)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg?maxAge=2592000)](#license)

## Simple and extremely flexible PHP event class

## Getting started

You need PHP >= 5.5 to use Buuum.

- [Install Buuum Event](#install)
- [Map your events](#map-your-events)
- [Add resolver](#add-resolver)
- [Fire events](#fire-events)

## Install

### System Requirements

You need PHP >= 5.5.0 to use Buuum\Event but the latest stable version of PHP is recommended.

### Composer

Buuum is available on Packagist and can be installed using Composer:

```
composer require buuum/phevent
```

### Manually

You may use your own autoloader as long as it follows PSR-0 or PSR-4 standards. Just put src directory contents in your vendor directory.

## Map your events

```php

use Buuum\Event;

$event = Event::getInstance();

$event->loadListeners(include_once __DIR__ . '/listeners.php');
$event->setResolver(new EventResolver());

```

## listeners.php

```php
use Buuum\Event;

return function(Event $event){

    $event->addListener('email.send.confirm', function(string $event_name){
        return $event_name;
    });
    
    $event->addListener('email.send.susbscribe', function($param1, $param2, string $event_name){
        return $event_name;
    });
    
    $event->addListener('email.send.rememberme', [App\Example::class, 'sendremember']);
};
```

## Add resolver
```php
$event->setResolver(new EventResolver());
```

## EventResolver.php
```php
use Buuum\Event;
class EventResolver implements EventResolverInterface
{

    public function __construct()
    {
    }

    public function resolve($handler)
    {
        return $handler;
    }
}
```

## Fire events
```php

\\ Static method
Event::eventFire($event_name);
\\ Method
$event->fire($event_name);

\\ Add params
Event::eventFire($event_name, $param1, $param2);
$event->fire($event_name, $param1, $param2);

```


## LICENSE

The MIT License (MIT)

Copyright (c) 2017 alfonsmartinez

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.