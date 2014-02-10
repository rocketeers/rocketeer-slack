<?php
namespace Rocketeer\Plugins;

use Illuminate\Support\ServiceProvider;

/**
 * Register the Slack plugin with Rocketeer
 */
class RocketeerSlackServiceProvider extends ServiceProvider
{
	/**
	 * Register the actions
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['config']->package('anahkiasen/rocketeer-slack', __DIR__.'/../../config');

		$this->app->bind('slack', function ($app) {
			return new slack($app['config']->get('rocketeer-slack::config'));
		});
	}

	/**
	 * Register slack in the Rocketeer hooks
	 *
	 * @return void
	 */
	public function boot()
	{
		Rocketeer::after('deploy', function ($task) {
			// Get user name
			$user = $task->server->getValue('slack.name');
			if (!$user) {
				$user = $task->command->ask('Who is deploying ?');
				$task->server->setValue('slack.name', $user);
			}

			// Get what was deployed
			$branch     = $task->rocketeer->getRepositoryBranch();
			$stage      = $task->rocketeer->getStage();
			$connection = $task->rocketeer->getConnection();

			// Get hostname
			$credentials = array_get($task->rocketeer->getAvailableConnections(), $connection);
			$host        = array_get($credentials, 'host');
			if ($stage) {
				$connection = $stage.'@'.$connection;
			}

			// Build message
			$message = $task->config->get('rocketeer-slack::message');
			$message = preg_replace('#\{([0-9])\}#', '%$1\$s', $message);
			$message = sprintf($message, $user, $branch, $connection, $host);

			$task->slack->send($message);
		});
	}
}