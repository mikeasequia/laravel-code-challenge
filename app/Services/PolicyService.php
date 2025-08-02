<?php

namespace App\Services;

use App\Models\PolicyRule;
use App\Models\User;
use App\Services\RuleEvaluator;
use Exception;

// Service class for easier integration
class PolicyService
{
    protected RuleEvaluator $ruleEvaluator;

    public function __construct(RuleEvaluator $ruleEvaluator)
    {
        $this->ruleEvaluator = $ruleEvaluator;
    }

    /**
     * Check if user can perform action
     */
    public function can(User $user, string $action): bool
    {
        try {
            return $this->ruleEvaluator->canPerformAction($user, $action);
        } catch (Exception $e) {
            return false;
        }
    }
}