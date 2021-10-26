<?php
declare(strict_types=1);


namespace Utils\TemplateVariablesExtractor\Exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidTemplate
 * @package Utils\TemplateVariablesExtractor\Exceptions
 */
final class InvalidTemplateException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct("The template used is not a valid template", 0, $previous);
    }
}