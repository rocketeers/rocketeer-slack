<?php
namespace Rocketeer\Plugins\Slack;

use Maknz\Slack\Attachment;
use Maknz\Slack\Client;
use Rocketeer\Plugins\AbstractNotifier;

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
            return new Client($this->getPluginOption('url'), $this->getPluginOption('attributes') ?: []);
        });
    }

    /**
     * Send a given message
     *
     * @param string $message
     *
     * @return void
     */
    public function send($message, $type)
    {
        /** @var Client $slack */
        $slack = $this->container->get('slack');

        /** @var \Maknz\Slack\Message $notification */
        $notification = $slack->createMessage();
        $room = $this->getPluginOption('room');
        $username = $this->getPluginOption('username');

        // Build attachment
        $color = $type === 'halt_deploy' ? 'danger' : 'good';
        $color = $type === 'before_deploy' ? 'grey' : $color;
        $attachment = new Attachment([
            'color' => $color,
            'text' => $message,
            'fallback' => $message,
            'mrkdwn_in' => ['text', 'pretext'],
        ]);

        // Build base message
        $notification
            ->setUsername($username)
            ->setChannel($room)
            ->attach($attachment);

        // Add optional emoji
        if ($emoji = $this->getPluginOption('emoji')) {
            $notification->setIcon($emoji);
        }

        $slack->sendMessage($notification);
    }
}
