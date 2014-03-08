<?php
namespace Rocketeer\Plugins\Slack;

use Crummy\Phlack\Phlack;
use Illuminate\Container\Container;
use Rocketeer\Plugins\Notifier;

class RocketeerSlack extends Notifier
{
  /**
   * Setup the plugin
   */
  public function __construct(Container $app)
  {
    parent::__construct($app);

    $this->configurationFolder = __DIR__.'/../config';
  }

  /**
   * Bind additional classes to the Container
   *
   * @param Container $app
   *
   * @return void
   */
  public function register(Container $app)
  {
    $app->bind('slack', function ($app) {
      return Phlack::factory(array(
        'username' => $app['config']->get('rocketeer-slack::username'),
        'token'    => $app['config']->get('rocketeer-slack::token'),
      ));
    });

    return $app;
  }

  /**
   * Get the default message format
   *
   * @return string
   */
  protected function getMessageFormat()
  {
    return $this->app['config']->get('rocketeer-slack::message');
  }

  /**
   * Send a given message
   *
   * @param string $message
   *
   * @return void
   */
  public function send($message)
  {
    $messageBuilder = $this->slack->getMessageBuilder();
    $room    = $this->config->get('rocketeer-slack::room');

    // Build base message
    $messageBuilder
      ->setText($message)
      ->setChannel($room);

    // Add optional emoji
    if ($emoji = $this->config->get('rocketeer-slack::emoji')) {
      $messageBuilder->setIconEmoji($emoji);
    }

    $response = $this->slack->send($messageBuilder->create());

    return $response;
  }
}
