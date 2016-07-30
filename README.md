# Slack for Rocketeer

Sends a basic deployment message to a Slack room :

![Slack](http://i.imgur.com/Dsh6bWd.jpeg)

## Installation

```shell
rocketeer plugin:install anahkiasen/rocketeer-slack
```

Then add this to the `plugins.loaded` array in your configuration:

```php
<?php
'loaded' => [
    'Rocketeer\Plugins\Slack\Slack',
],
```

## Usage

To export the configuration, simply run `rocketeer plugin:config` then edit `.rocketeer/config/plugins/rocketeer-slack`.