# Slack for Rocketeer

Sends a basic deployment message to a Slack room :

![Slack](http://i.imgur.com/Dsh6bWd.jpeg)

To setup add this to your `composer.json` and update :

```json
"anahkiasen/rocketeer-slack": "dev-master"
```

Then you'll need to set it up, so do `artisan config:publish anahkiasen/rocketeer-slack` and complete the configuration in `app/packages/anahkiasen/rocketeer-slack/config.php`.

Once that's done add the following to your providers array in `app/config/app.php` :

```php
'Rocketeer\Plugins\Slack\RocketeerSlackServiceProvider',
```

And that's pretty much it.
