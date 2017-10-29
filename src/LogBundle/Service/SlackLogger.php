<?php declare(strict_types=1);

namespace LogBundle\Service;

use Psr\Log\AbstractLogger;
use LogBundle\Service\Message\Attachment;
use LogBundle\Service\Message\Field;
use LogBundle\Service\Message\Message;

/**
 * @package LogBundle\Service
 */
class SlackLogger extends AbstractLogger
{
    /**
     * @var SlackClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $levels;

    /**
     * @param SlackClient   $client
     * @param string[]|null $levels
     */
    public function __construct(SlackClient $client, array $levels = null)
    {
        $this->client = $client;
        $this->levels = $levels !== null ? $levels : [
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

        $parsedMessage = $this->parseMessage($message, $context);

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

        $this->client->sendMessage($slackMessage);
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
                $replacePairs['{'.$name.'}'] = 'NULL';
            } elseif (is_scalar($value)) {
                $replacePairs['{'.$name.'}'] = $value;
            } elseif (is_object($value)) {
                if (method_exists($value, '__toString')) {
                    $replacePairs['{'.$name.'}'] = (string)$value;
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
}
