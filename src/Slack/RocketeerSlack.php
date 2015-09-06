<?php
namespace Rocketeer\Plugins\Slack;

use Illuminate\Container\Container;
use Maknz\Slack\Client;
use Rocketeer\Plugins\AbstractNotifier;
use Rocketeer\Plugins\Notifier;

class RocketeerSlack extends AbstractNotifier
{
	/**
	 * Setup the plugin
	 *
	 * @param Container $app
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
			return new Client($app['config']->get('rocketeer-slack::url'));
		});

		return $app;
	}

	/**
	 * Get the default message format
	 *
	 * @param string $message The message handle
	 *
	 * @return string
	 */
	public function getMessageFormat($message)
	{
		return $this->app['config']->get('rocketeer-slack::'.$message);
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
		/** @var \Maknz\Slack\Message $notification */
		$notification = $this->slack->createMessage();
		$room         = $this->config->get('rocketeer-slack::room');

		// Build base message
		$notification->setChannel($room);
		if (is_array($message)) {
			$notification->attach($message);
		} else {
			$notification->setText($message);
		}

		// Add optional emoji
		if ($emoji = $this->config->get('rocketeer-slack::emoji')) {
			$notification->setIcon($emoji);
		}

		$this->slack->sendMessage($notification);
	}
}
