<?php

namespace LogicToolkit;

use InvalidArgumentException;
use LogicToolkit\Support\InputParser;
use LogicToolkit\Tools\NumberTools;
use LogicToolkit\Tools\SearchTools;
use LogicToolkit\Tools\SortTools;
use LogicToolkit\Tools\TextTools;
use Throwable;

class ConsoleApplication
{
    private InputParser $parser;
    private SearchTools $searchTools;
    private SortTools $sortTools;
    private TextTools $textTools;
    private NumberTools $numberTools;

    public function __construct()
    {
        $this->parser = new InputParser();
        $this->searchTools = new SearchTools();
        $this->sortTools = new SortTools();
        $this->textTools = new TextTools();
        $this->numberTools = new NumberTools();
    }

    /**
     * @param array<int, string> $argv
     */
    public function run(array $argv): int
    {
        try {
            $result = $this->dispatch($argv);
            echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
            return 0;
        } catch (Throwable $error) {
            fwrite(STDERR, $error->getMessage() . PHP_EOL);
            fwrite(STDERR, $this->helpText() . PHP_EOL);
            return 1;
        }
    }

    /**
     * @param array<int, string> $argv
     * @return array<string, mixed>
     */
    public function dispatch(array $argv): array
    {
        $domain = $argv[1] ?? 'help';
        $action = $argv[2] ?? 'help';
        $options = $this->parser->parseOptions(array_slice($argv, 3));

        if ($domain === 'help' || $action === 'help') {
            return ['help' => $this->helpText()];
        }

        switch ($domain) {
            case 'search':
                return $this->runSearch($action, $options);
            case 'sort':
                return $this->runSort($action, $options);
            case 'text':
                return $this->runText($action, $options);
            case 'number':
                return $this->runNumber($action, $options);
            default:
                throw new InvalidArgumentException("Unknown command group: {$domain}");
        }
    }

    /**
     * @param array<string, string> $options
     * @return array<string, mixed>
     */
    private function runSearch(string $action, array $options): array
    {
        $values = $this->parser->numberList($options['list'] ?? '');
        $target = $this->parser->number($options['target'] ?? null, 'target');

        if ($action === 'linear') {
            $index = $this->searchTools->linear($values, $target);
        } elseif ($action === 'binary') {
            $index = $this->searchTools->binary($values, $target);
        } else {
            throw new InvalidArgumentException("Unknown search action: {$action}");
        }

        return [
            'command' => "search {$action}",
            'target' => $target,
            'index' => $index,
            'found' => $index !== null,
        ];
    }

    /**
     * @param array<string, string> $options
     * @return array<string, mixed>
     */
    private function runSort(string $action, array $options): array
    {
        $values = $this->parser->numberList($options['list'] ?? '');

        if ($action === 'quick') {
            $sorted = $this->sortTools->quick($values);
        } elseif ($action === 'insertion') {
            $sorted = $this->sortTools->insertion($values);
        } else {
            throw new InvalidArgumentException("Unknown sort action: {$action}");
        }

        return [
            'command' => "sort {$action}",
            'input' => $values,
            'sorted' => $sorted,
        ];
    }

    /**
     * @param array<string, string> $options
     * @return array<string, mixed>
     */
    private function runText(string $action, array $options): array
    {
        if ($action === 'palindrome') {
            $value = $options['value'] ?? '';
            return [
                'command' => 'text palindrome',
                'value' => $value,
                'result' => $this->textTools->isPalindrome($value),
            ];
        }

        if ($action === 'anagram') {
            $left = $options['left'] ?? '';
            $right = $options['right'] ?? '';
            return [
                'command' => 'text anagram',
                'left' => $left,
                'right' => $right,
                'result' => $this->textTools->isAnagram($left, $right),
            ];
        }

        throw new InvalidArgumentException("Unknown text action: {$action}");
    }

    /**
     * @param array<string, string> $options
     * @return array<string, mixed>
     */
    private function runNumber(string $action, array $options): array
    {
        if ($action === 'gcd') {
            $a = $this->parser->integer($options['a'] ?? null, 'a');
            $b = $this->parser->integer($options['b'] ?? null, 'b');
            return ['command' => 'number gcd', 'result' => $this->numberTools->gcd($a, $b)];
        }

        if ($action === 'factorial') {
            $value = $this->parser->integer($options['value'] ?? null, 'value');
            return ['command' => 'number factorial', 'result' => $this->numberTools->factorial($value)];
        }

        if ($action === 'fibonacci') {
            $value = $this->parser->integer($options['value'] ?? null, 'value');
            return ['command' => 'number fibonacci', 'result' => $this->numberTools->fibonacci($value)];
        }

        throw new InvalidArgumentException("Unknown number action: {$action}");
    }

    private function helpText(): string
    {
        return implode(PHP_EOL, [
            'PHP Logic Toolkit',
            'Usage:',
            '  php bin/logic-toolkit search linear --list=4,8,15 --target=8',
            '  php bin/logic-toolkit search binary --list=1,3,5,8 --target=5',
            '  php bin/logic-toolkit sort quick --list=9,4,7,1',
            '  php bin/logic-toolkit text palindrome --value="Never odd or even"',
            '  php bin/logic-toolkit text anagram --left=listen --right=silent',
            '  php bin/logic-toolkit number gcd --a=84 --b=30',
            '  php bin/logic-toolkit number factorial --value=6',
            '  php bin/logic-toolkit number fibonacci --value=10',
        ]);
    }
}
