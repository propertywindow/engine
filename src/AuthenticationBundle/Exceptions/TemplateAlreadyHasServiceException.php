<?php declare(strict_types=1);

namespace AuthenticationBundle\Exceptions;

use AppBundle\Exceptions\Exception;

/**
 * @package AuthenticationBundle\Exceptions
 */
class TemplateAlreadyHasServiceException extends Exception
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var int
     */
    private $service;

    /**
     * @param string $template
     * @param int    $service
     *
     * @internal param string $id
     */
    public function __construct(string $template, int $service)
    {
        $this->template = $template;
        $this->service  = $service;

        parent::__construct(sprintf("%s template already has service with id: %d", $template, $service));
    }
}
