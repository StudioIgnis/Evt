[![Packagist Version](http://img.shields.io/packagist/v/studioignis/evt.svg?style=flat-square)](https://packagist.org/packages/studioignis/evt)
[![Packagist Downloads](http://img.shields.io/packagist/dt/studioignis/evt.svg?style=flat-square)](https://packagist.org/packages/studioignis/evt)
![Packagist License](http://img.shields.io/packagist/l/studioignis/evt.svg?style=flat-square)

StudioIgnis Evt
===============

Easily implement domain events in your project.

_Originally inspired by laracasts/commander_

Installation
------------

Install through composer by adding the package to your composer.json

```javascript
{
    "require": {
        "studioignis/evt": "~1.0"
    }
}
```

Or using the command:

```shell
$ composer require studioignis/evt:~1.0
```

Usage
-----

It is really simple, you just need the event dispatcher instance then you can
start adding listeners to it:

```php
$dispatcher = new StudioIgnis\Evt\EventDispatcher;
$dispatcher->addListener(
    'UserWasRegistered',
    new SendEmailUponUserRegistration($mailer)
);
```

After that you can start dispatching events:

```php
$dispatcher->dispatch([new Acme\Events\UserWasRegistered($name, $email)]);
```

You can dispatch multiple events at once, that's why `dispatch()` needs an array
of events.

### Events

The events are simple DTOs (data transfer objects), but should conform to the
`StudioIgnis\Evt\Event` contract. This contract states only one method:
`getEventName()` that is used to get the name of the event to know which
listeners to run.

A trait is provided that fulfills this contract with a simple default strategy.
If yout event is `Acme\Events\UserWasRegistered`, the trait's `getEventName()`
will use the event class short name as the event name, that is
`UserWasRegistered`.

Here's an example:

```php
namespace Acme\Events;

use StudioIgnis\Evt\Event;
use StudioIgnis\Evt\Traits\EventName;

class UserWasRegistered implements Event
{
    use EventName;
    
    private $name;
    
    private $email;
    
    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
}
```

If we weren't using the EventName trait, we would have had to add the
`getEventName()` method returning the event name. You don't have to use the
trait, it is just a convenience, you may need to provide a custom name, in that
case you wouldn't use it.

### Listeners

An event listener is a class that should conform to the EventListener contract.
This contract defines only one method: `handle(Event $event)` that expects the
dispatched event.

```php
namespace Acme\Events;

use StudioIgnis\Evt\EventListener;

class SendEmailUponUserRegistration implements EventListener
{
    private $mailer;
    
    public function __construct($mailer)
    {
        // Your hypothetical mailer class
        $this->mailer = $mailer;
    }
    
    public function handle(Event $event)
    {
        $this->mailer->sendWelcomeEmail($event->getEmail(), $event->getName());
    }
}
```

_I know, I know, everybody uses the same example, forgive my lack of
originality :D_

#### Resolving listeners upon dispatch

Instead of passing an instantiated listener, you can pass a string abstraction:
 
```php
$dispatcher->addListener('SomeEvent', 'Acme\Events\SomeListener');
// or
$dispatcher->addListener('SomeEvent', 'listeners.some_event_listener');
```

This way the listener will be instantiated when events are dispatched.

But in order to achieve this, the dispatcher must be created with an app
container:

```php
$dispatcher = new Dispatcher($container);
```

The container must conform to the `\StudioIgnis\Evt\Support\Container` contract.

A default container is provided for Laravel applications, so this is done
automatically when a dispatcher is resolved out of the IoC container.

### Raising events from your entities

You'll most likely be raising events from your entities. For this purpose you
have the convenient HasDomainEvents trait.

This trait adds two methods, `raise(Event $event)` and `releaseEvents()`.
`raise(Event $event)`, as the name states, adds events pending to be dispatched.
`releaseEvents()` returns the raised events and clear the pending events.

Let's see an example:

```php
namespace Acme;

use StudioIgnis\Evt\Traits\HasDomainEvents;

class User implements EventListener
{
    use HasDomainEvents;
    
    public function __construct($name, $email)
    {
        // Init your params, invariants, etc
        
        $this->raise(new Events\UserWasRegistered($name, $email));
    }
}
```
Now (maybe inside a [command handler](https://github.com/studioignis/cmd) class)
you can do this:

```php
$dispatcher->dispatch($user->releaseEvents());
```

### Laravel Integration

A service provider for the Laravel framework is included in this package.
You'll need to add it to your `config/app.php` file:

'\StudioIgnis\Evt\Laravel\ServiceProvider'

This way, you can inject it as a dependency and will be automatically resolved
out of the IoC container:

```php
class SomeController extends Controller
{
    private $dispatcher;
    
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
```

The main benefit, already stated before, is that the container will be passed to
the dispatcher, allowing you to pass abstracts as your listeners to be resolved
from the container.

#### Replacing the dispatcher

If for some reason you need to use your own custom dispatcher, you can change it
in the config. To do this you would need to publish the config for this package:

```shell
$ php artisan config:publish studioignis/evt
```

And change the 'dispatcher' key to point to your dispatcher class.

```php
return [
    /**
     * Which concrete dispatcher implementation to map to
     * StudioIgnis\Evt\Dispatcher contract.
     */
    'dispatcher' => 'StudioIgnis\Evt\EventDispatcher',
];

```

License
-------

Copyright (c) 2014 Luciano Longo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
