<?php

namespace Utils\VariablesExtractor;

use Utils\VariablesExtractor\Exceptions\InvalidVariableClosure;

/**
 * Class VariablesExtractorImpl
 * @package Utils\VariablesExtractor
 */
final class VariablesExtractorImpl implements VariablesExtractor
{
    // TODO : Extract to environment variable
    private const VARIABLE_REGEXES = [["{% set", ["=", ","]], ["{{", ["|", "}}", ".", "["]]];

    private array $variables = [];

    /**
     * getVariables
     * @param string $content
     * @return array
     * @throws InvalidVariableClosure
     */
    public function getVariables(string $content): array
    {
        foreach (self::VARIABLE_REGEXES as $regex) {
            $this->fillVariables($content, $regex);
        }
        return array_unique($this->variables);
    }

    /**
     * fillVariables
     * @param string $templateContent
     * @param array $variableRegex
     * @throws InvalidVariableClosure
     */
    private function fillVariables(string $templateContent, array $variableRegex)
    {
        $start = $variableRegex[0];
        $starterPositionInTemplate = strpos($templateContent, $start);

        if (!$starterPositionInTemplate) {
            return;
        }

        $starterPositionInTemplate += strlen($start);
        $end = $variableRegex[1];
        $firstEndOccurrence = $this->getFirstOccurrence($templateContent, $end, $starterPositionInTemplate);
        $len = strpos($templateContent, $firstEndOccurrence) - $starterPositionInTemplate;
        $trimmedVariable = trim(substr($templateContent, $starterPositionInTemplate, $len));

        array_push($this->variables, $trimmedVariable);

        $remainingTemplate = $this->getRemainingTemplate($templateContent, $firstEndOccurrence);

        $this->fillVariables($remainingTemplate, $variableRegex);
    }

    /**
     * getFirstOccurrence
     * @param string $string
     * @param array $searchedArr
     * @param int $startPosition
     * @return mixed
     * @throws InvalidVariableClosure
     */
    private function getFirstOccurrence(string $string, array $searchedArr, int $startPosition)
    {
        $map = [];

        foreach ($searchedArr as $searched) {
            $appears = str_contains($string, $searched);
            if ($appears) {
                $position = strpos($string, $searched);
                $splitter = $searched;
                if ($position > $startPosition) {
                    array_push($map, [$position, $splitter]);
                }
            }
        }

        if (empty($map)) {
            throw new InvalidVariableClosure();
        }

        return min($map)[1];
    }

    /**
     * getRemainingTemplate
     * @param string $templateContent
     * @param $firstEndOccurrence
     * @return bool|string
     */
    private function getRemainingTemplate(string $templateContent, $firstEndOccurrence)
    {
        return substr($templateContent, strpos($templateContent, $firstEndOccurrence) + strlen($firstEndOccurrence));
    }
}