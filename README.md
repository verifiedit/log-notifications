[![Build](https://github.com/verifiedit/log-notifications/actions/workflows/build.yml/badge.svg)](https://github.com/verifiedit/log-notifications/actions/workflows/build.yml)

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
    sentAt: string,
    subject: string|null
}
```
  
application: the name of which application is sending the notification.  
- defaults to your APP_NAME env variable with a fallback to 'Laravel', or this can be set in your ```log-notifications``` config by running ```php artisan vendor:publish --tag=log-notifications-config```. 
  
message: the raw content sent to your recipient.
- For email, this assumes you are using Laravel's MailMessage
- For sms, this assumes you are using verifiedit/laravel-notification-channel-clicksend
  
reference: the uuid of the notification.  
  
recipient: the ```Notifiable``` the notification was sent to. <b>this assumes you are following laravel conventions for 'routeNotificationFor()'</b>.  
  
serviceCommunications: the response from the notification.  
  
channel: the notification channel.  