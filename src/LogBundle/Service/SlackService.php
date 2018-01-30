<?php declare(strict_types=1);

namespace LogBundle\Service;

use AppBundle\Exceptions\SettingsNotFoundException;
use AppBundle\Service\SettingsService;
use Psr\Log\AbstractLogger;
use LogBundle\Service\Message\Attachment;
use LogBundle\Service\Message\Field;
use LogBundle\Service\Message\Message;

/**
 * Slack Service
 */
class SlackService extends AbstractLogger
{
    /**
     * @var string
     */
    protected $levels;

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
     * @var boolean
     */
    protected $slackEnabled = false;

    /**
     * @param SettingsService $settingsService
     *
     * @throws SettingsNotFoundException
     */
    public function __construct(SettingsService $settingsService)
    {
        $settings           = $settingsService->getSettings();
        $this->hookUri      = $settings->getSlackURL();
        $this->name         = $settings->getSlackUsername();
        $this->slackEnabled = $settings->getSlackEnabled();
        $this->iconUrl      = null;

        $this->levels = [
            'emergency',
            'alert',
            'critical',
            'error',
            'warning',
            'notice',
            'info',
        ];
    }

    /**
     * @param string $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        if (!in_array($level, $this->levels)) {
            return;
        }

        if (!$this->slackEnabled) {
            return;
        }

        $this->channel = $this->determineChannel($level);
        $parsedMessage = $this->parseMessage(urlencode($message), $context);

        $attachment = Attachment::create()
                                ->color($this->determineColor($level))
                                ->title(ucfirst($level))
                                ->text($parsedMessage)
                                ->ts();

        foreach ($context as $k => $v) {
            $attachment->addField(new Field($k, $v, true));
        }

        $slackMessage = new Message();
        $slackMessage->attach($attachment);


        $this->sendMessage($slackMessage);
    }

    /**
     * @param string  $message
     * @param mixed[] $context
     *
     * @return string
     */
    protected function parseMessage($message, array $context)
    {
        $replacePairs = [];

        foreach ($context as $name => $value) {
            if ($value === null) {
                $replacePairs['{' . $name . '}'] = 'NULL';
            } elseif (is_scalar($value)) {
                $replacePairs['{' . $name . '}'] = $value;
            } elseif (is_object($value)) {
                if (method_exists($value, '__toString')) {
                    $replacePairs['{' . $name . '}'] = (string)$value;
                }
            }
        }

        return strtr($message, $replacePairs);
    }

    /**
     * @param string $level
     *
     * @return string
     */
    protected function determineColor($level)
    {
        switch ($level) {
            case 'emergency':
            case 'alert':
            case 'critical':
            case 'error':
                return '#E64A19';
            case 'warning':
                return '#FFA726';
            case 'notice':
                return '#E0E0E0';
            case 'info':
            case 'debug':
            default:
                return '#90CAF9';
        }
    }

    /**
     * @param string $level
     *
     * @return string
     */
    protected function determineChannel($level)
    {
        switch ($level) {
            case 'emergency':
            case 'alert':
            case 'critical':
            case 'error':
            case 'debug':
            case 'warning':
                return '#errors';
            case 'notice':
            case 'info':
                return '#info';
            default:
                return '#errors';
        }
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'payload=' . json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (defined('CURLOPT_SAFE_UPLOAD')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        }

        curl_exec($ch);
        curl_close($ch);
    }
}
