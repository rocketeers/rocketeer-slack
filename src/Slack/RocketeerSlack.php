<?php
namespace Rocketeer\Plugins\Slack;

use Maknz\Slack\Client;
use Rocketeer\Plugins\AbstractNotifier;
use Rocketeer\Plugins\Notifier;

class RocketeerSlack extends AbstractNotifier
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->container->share('slack', function () {
            return new Client($this->config->getPluginOption('rocketeer-slack', 'url'));
        });
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
        return $this->config->getPluginOption('rocketeer-slack', $message);
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
        $room = $this->config->getPluginOption('rocketeer-slack', 'room');
        $username = $this->config->getPluginOption('rocketeer-slack', 'username');

        // Build base message
        $notification
            ->setUsername($username)
            ->setText($message)
            ->setChannel($room);

        // Add optional emoji
        if ($emoji = $this->config->getPluginOption('rocketeer-slack', 'emoji')) {
            $notification->setIcon($emoji);
        }

        $this->slack->sendMessage($notification);
    }
}
