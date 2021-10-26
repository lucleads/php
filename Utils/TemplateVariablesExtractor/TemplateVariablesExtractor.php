<?php

namespace Utils\TemplateVariablesExtractor;


/**
 * Interface TemplateVariablesExtractor
 * @package Utils\TemplateVariablesExtractor
 */
interface TemplateVariablesExtractor
{
    public function getTemplateVariables(): array;

    public function getTemplateNeededVariables(): array;

    public function getTemplateAlreadyDefinedVariables(): array;
}