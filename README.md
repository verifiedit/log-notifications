## Installation

```composer require verifiedit/log-notifications```

Provide a concrete implementation for the ```NotificationLogContract``` and provide it in your ```AppServiceProvider```

```php
$this->app
    ->when(Verifiedit\LogNotifications\Listeners\LogNotification\LogNotification::class)
    ->needs(Verifiedit\LogNotifications\Contracts\NotificationLogContract::class)
    ->give(--YOUR IMPLEMENTATION--);
```

## Usage

Each notification that laravel sends will now be listened to.  
You can define your implementation of what you want to do with the notification data however you would like.  
The data structure returned by ```LogNotification``` and passed to your implementation of ```store``` is:
```php
array{
    application: string,
    message: string,
    reference: string,
    recipient: string,
    serviceCommunications: string,
    channel: string,
    sentAt: string
}
```

application is the name of which application is sending the notification.  
- this must be configured in your ```log-notifications``` config.