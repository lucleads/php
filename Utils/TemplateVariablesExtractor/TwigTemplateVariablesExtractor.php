<?php

namespace Utils\TemplateVariablesExtractor;

use Utils\TemplateVariablesExtractor\Exceptions\InvalidTemplateException;

/**
 * Class TwigTemplateVariablesExtractor
 * @package Utils\TemplateVariablesExtractor
 */
final class TwigTemplateVariablesExtractor implements TemplateVariablesExtractor
{
    // TODO : Extract to environment variable
    private const TWIG_VARIABLE_REGEXES = [["{% set", ["=", ","]], ["{{", ["|", "}}", ".", "["]], [" in", ["%}"]]];
    private const TWIG_ALREADY_DEFINED_VARIABLE_REGEXES = [["{% set", ["=", ","]], ["{% for ", ["in"]]];

    private string $templateContent;

    private array $variables;

    public function __construct(string $templateContent)
    {
        $this->templateContent = $templateContent;
    }

    /**
     * @throws InvalidTwigTemplate
     * @throws InvalidTemplateException
     */
    public function getTemplateNeededVariables(): array
    {
        $allTemplateVariables = $this->getTemplateVariables();
        $alreadyDefinedTemplateVariables = $this->getTemplateAlreadyDefinedVariables();
        return array_diff($allTemplateVariables, $alreadyDefinedTemplateVariables);
    }

    /**
     * @throws InvalidTwigTemplate
     * @throws InvalidTemplateException
     */
    public function getTemplateVariables(): array
    {
        return $this->getVariablesMap(self::TWIG_VARIABLE_REGEXES);
    }

    /**
     * @throws InvalidTwigTemplate
     * @throws InvalidTemplateException
     */
    public function getTemplateAlreadyDefinedVariables(): array
    {
        return $this->getVariablesMap(self::TWIG_ALREADY_DEFINED_VARIABLE_REGEXES);
    }

    /**
     * getVariablesMap
     * @param array $regexes
     * @return array
     * @throws InvalidTwigTemplate|InvalidTemplateException
     */
    private function getVariablesMap(array $regexes): array
    {
        $this->resetVariables(); //TODO: check if it makes sense to create variables array as a class var
        foreach ($regexes as $regex) {
            $startIndicator = $regex[0];
            if ($this->str_contains($this->templateContent, $startIndicator)) {
                $this->populateVariablesArray($this->templateContent, $regex);
            }
        }
        return array_unique($this->variables);
    }

    /**
     * fillVariables
     * @param string $textWithVariables
     * @param array $variableRegex
     * @throws InvalidTwigTemplate
     * @throws InvalidTemplateException
     */
    private function populateVariablesArray(string $textWithVariables, array $variableRegex)
    {
        $start = $variableRegex[0];
        $starterPositionInTemplate = strpos($textWithVariables, $start);

        $starterPositionInTemplate += strlen($start);
        $end = $variableRegex[1];
        $firstEndOccurrence = $this->getFirstOccurrence($textWithVariables, $end, $starterPositionInTemplate);
        $len = strpos($textWithVariables, $firstEndOccurrence) - $starterPositionInTemplate;
        $trimmedVariable = trim(substr($textWithVariables, $starterPositionInTemplate, $len));

        array_push($this->variables, $trimmedVariable);

        $remainingText = $this->getRemainingTemplate($textWithVariables, $firstEndOccurrence);

        if ($this->str_contains($remainingText, $start)) {
            $this->populateVariablesArray($remainingText, $variableRegex);
        }
    }

    /**
     * getFirstOccurrence
     * @param string $text
     * @param array $searchedArr
     * @param int $startPosition
     * @return string
     * @throws InvalidTwigTemplate
     * @throws InvalidTemplateException
     */
    private function getFirstOccurrence(string $text, array $searchedArr, int $startPosition): string
    {
        $map = [];

        foreach ($searchedArr as $searched) {
            $appears = $this->str_contains($text, $searched);
            if ($appears) {
                $validPosition = $this->getNextValidOccurrence($text, $searched, $startPosition);
                if ($validPosition !== false) {
                    array_push($map, [$validPosition, $searched]);
                }
            }
        }

        if (empty($map)) {
            throw new InvalidTemplateException();
        }

        return min($map)[1];
    }

    /**
     * getRemainingTemplate
     * @param string $templateContent
     * @param string $firstEndOccurrence
     * @return bool|string
     */
    private function getRemainingTemplate(string $templateContent, string $firstEndOccurrence)
    {
        return substr($templateContent, strpos($templateContent, $firstEndOccurrence) + strlen($firstEndOccurrence));
    }

    private function resetVariables(): void
    {
        $this->variables = [];
    }

    /**
     * getNextValidOccurrence
     * @param string $text
     * @param string $searched
     * @param int $startPosition
     * @param int $initialSum
     * @return int | bool
     * @throws InvalidTwigTemplate
     */
    private function getNextValidOccurrence(string $text, string $searched, int $startPosition, int $initialSum = 0)
    {
        $position = strpos($text, $searched);
        if ($position > $startPosition) {
            return $position + $initialSum;
        } elseif (substr_count($text, $searched) > 1) {
            $nextStart = $position + strlen($searched);
            $ignoreNextOccurrence = substr($text, $nextStart);
            return $this->getNextValidOccurrence($ignoreNextOccurrence, $searched, $startPosition - $nextStart, $position);
        }

        return false;
    }

    /**
     * str_contains
     * @param string|null $haystack
     * @param string|null $needle
     * @return bool
     * @internal - Native Symfony library method
     */
    private function str_contains(?string $haystack, ?string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}