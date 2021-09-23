<?php

namespace Utils\VariablesExtractor;


/**
 * Interface VariablesExtractor
 * @package Utils\VariablesExtractor
 */
interface VariablesExtractor
{
    public function getVariables(string $content): array;
}