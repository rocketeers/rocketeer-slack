<?php
namespace Rocketeer\Plugins\Slack;

use Crummy\Phlack\Phlack;
use Illuminate\Container\Container;
use Rocketeer\Plugins\Notifier;
use Rocketeer\TasksHandler;

class RocketeerSlack extends Notifier
{

  /**
   * What message to print.
   * @var string
   */
  protected $message;

  /**
   * Setup the plugin
   */
  public function __construct(Container $app)
  {
    parent::__construct($app);

    $this->configurationFolder = __DIR__.'/../config';
  }

  /**
   * Register Tasks with Rocketeer
   *
   * @param TasksHandler $queue
   *
   * @return void
   */
  public function onQueue(TasksHandler $queue)
  {
    $me = $this;

    $queue->before('deploy', function ($task) use ($me) {

      // Don't send a notification if pretending to deploy
      if ($task->command->option('pretend')) {
        return;
      }

      $me->message = 'message_prepare';

      // Build message and send it
      $message = $me->makeMessage();
      $me->send($message);

    }, -10);

    $queue->after('deploy', function ($task) use ($me) {

      // Don't send a notification if pretending to deploy
      if ($task->command->option('pretend')) {
        return;
      }

      $me->message = 'message_finish';

      // Build message and send it
      $message = $me->makeMessage();
      $me->send($message);

    }, -10);
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
      return $this->app['config']->get('rocketeer-slack::' . $this->message);
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
