<?php

namespace App\Services;

use App\Models\PolicyRule;
use App\Models\User;

class RuleEvaluator
{
    protected array $supportedOperators = [
        '==', '!=', '>', '<', '>=', '<=',
        'in', 'not_in', 'contains', 'not_contains',
        'starts_with', 'ends_with', 'regex',
        'is_null', 'is_not_null'
    ];

    /**
     * Check if a user can perform an action based on policy rules.
     */
    public function canPerformAction(User $user, string $action): bool
    {
        $policyRule = PolicyRule::active()->forAction($action)->first();

        // Deny if no rule is found
        if (!$policyRule) {
            return false;
        }

        return $this->evaluateRuleSet($user, $policyRule->rules);
    }

    /**
     * Evaluate all rules in a set (AND logic).
     */
    public function evaluateRuleSet(User $user, array $rules): bool
    {
        foreach ($rules as $rule) {
            if (!$this->evaluateRule($user, $rule)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Evaluate a single rule.
     */
    public function evaluateRule(User $user, array $rule): bool
    {
        $this->validateRule($rule);

        $actual = data_get($user, $rule['field']);
        $operator = $rule['operator'];
        $expected = $rule['value'] ?? null;

        return $this->compare($actual, $operator, $expected);
    }

    /**
     * Compare values using the specified operator.
     */
    protected function compare($actual, string $operator, $expected): bool
    {
        return match ($operator) {
            '==' => $actual == $expected,
            '!=' => $actual != $expected,
            '>'  => $this->numeric($actual, $expected, fn($a, $b) => $a > $b),
            '<'  => $this->numeric($actual, $expected, fn($a, $b) => $a < $b),
            '>=' => $this->numeric($actual, $expected, fn($a, $b) => $a >= $b),
            '<=' => $this->numeric($actual, $expected, fn($a, $b) => $a <= $b),
            'in' => is_array($expected) && in_array($actual, $expected),
            'not_in' => is_array($expected) && !in_array($actual, $expected),
            'contains' => $this->contains($actual, $expected),
            'not_contains' => !$this->contains($actual, $expected),
            'starts_with' => is_string($actual) && str_starts_with($actual, $expected),
            'ends_with' => is_string($actual) && str_ends_with($actual, $expected),
            'regex' => is_string($actual) && preg_match($expected, $actual),
            'is_null' => is_null($actual),
            'is_not_null' => !is_null($actual),
            default => throw new \Exception("Unsupported operator: {$operator}"),
        };
    }

    /**
     * Numeric comparison helper.
     */
    protected function numeric($a, $b, callable $fn): bool
    {
        if (!is_numeric($a) || !is_numeric($b)) {
            throw new \Exception("Non-numeric values cannot be compared.");
        }
        return $fn($a, $b);
    }

    /**
     * Check if string or array contains value.
     */
    protected function contains($haystack, $needle): bool
    {
        if (is_string($haystack)) {
            return str_contains($haystack, $needle);
        }
        if (is_array($haystack)) {
            return in_array($needle, $haystack);
        }
        return false;
    }

    /**
     * Validate rule structure.
     */
    protected function validateRule(array $rule): void
    {
        if (!isset($rule['field'])) {
            throw new \Exception("Rule missing required 'field' key");
        }
        if (!isset($rule['operator'])) {
            throw new \Exception("Rule missing required 'operator' key");
        }
        if (!in_array($rule['operator'], $this->supportedOperators)) {
            throw new \Exception("Unsupported operator: {$rule['operator']}");
        }
    }
}