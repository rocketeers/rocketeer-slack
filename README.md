# Campfire for Rocketeer

Sends a basic deployment message to a Campfire room :

![Campfire](http://i.imgur.com/iIzpvyr.png)

To setup add this to your `composer.json` and update :

```json
"anahkiasen/rocketeer-campfire": "dev-master"
```

Then you'll need to set it up, so do `artisan config:publish anahkiasen/rocketeer-campfire` and complete the configuration in `app/packages/anahkiasen/rocketeer-campfire/config.php` :

- subdomain: http://{subdomain}.campfirenow.com.
- room: Numeric ID for the room you want the message sent to.
- key: API key for the user you the message sent from.

Once that's done add the following to your providers array in `app/config/app.php` :

```php
'Rocketeer\Plugins\RocketeerCampfireServiceProvider',
```

And that's pretty much it.