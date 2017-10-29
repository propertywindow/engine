<?php declare(strict_types=1);

namespace LogBundle\Service;

use LogBundle\Service\Message\Message;

/**
 * @package LogBundle\Service
 */
class SlackClient
{
    /**
     * @var string
     */
    protected $hookUri;

    /**
     * @var string|null
     */
    protected $channel;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $iconUrl;

    /**
     * @param string $hookUri
     * @param string $channel
     * @param string $name
     * @param string $icon
     */
    public function __construct(
        $hookUri,
        $channel = null,
        $name = 'Logger',
        $icon = null
    ) {
        $this->hookUri = $hookUri;
        $this->channel = $channel;
        $this->name    = $name;
        $this->iconUrl = $icon;
    }

    /**
     * @param Message $message
     */
    public function sendMessage(Message $message)
    {
        $payload = array_merge($message->toArray(), [
            'username' => $this->name,
            'channel'  => $this->channel,
        ]);

        if ($this->iconUrl) {
            $payload['icon_url'] = $this->iconUrl;
        }

        $ch = curl_init($this->hookUri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'payload='.json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (defined('CURLOPT_SAFE_UPLOAD')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        }

        curl_exec($ch);
        curl_close($ch);
    }
}
