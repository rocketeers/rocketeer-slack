<?php
namespace Rocketeer\Plugins\Slack;

use Maknz\Slack\Client;
use Rocketeer\Plugins\AbstractNotifier;
use Rocketeer\Plugins\Notifier;

class Slack extends AbstractNotifier
{
    /**
     * @var string
     */
    protected $name = 'rocketeer-slack';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->container->share('slack', function () {
            return new Client($this->getPluginOption('url'));
        });
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
        /** @var Client $slack */
        $slack = $this->container->get('slack');

        /** @var \Maknz\Slack\Message $notification */
        $notification = $slack->createMessage();
        $room = $this->getPluginOption('room');
        $username = $this->getPluginOption('username');

        // Build base message
        $notification
            ->setUsername($username)
            ->setText($message)
            ->setChannel($room);

        // Add optional emoji
        if ($emoji = $this->getPluginOption('emoji')) {
            $notification->setIcon($emoji);
        }

        $slack->sendMessage($notification);
    }
}
