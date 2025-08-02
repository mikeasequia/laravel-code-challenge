<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use App\Events\ModelTransitioned;
use App\Events\ModelTransitioning;
use Exception;

trait StateMachine
{
    public function transitionTo(string $newState)
    {
        $currentState = $this->{$this->getStateField()};

        $states = static::$states ?? [];
        if (!isset($states[$currentState]) || !in_array($newState, $states[$currentState])) {
            throw new Exception("Invalid state transition from '$currentState' to '$newState'.");
        }

        Event::dispatch(new ModelTransitioning($this, $currentState, $newState));

        $this->{$this->getStateField()} = $newState;
        $this->save();

        Event::dispatch(new ModelTransitioned($this, $currentState, $newState));
    }

    protected function getStateField()
    {
        return property_exists($this, 'stateField') ? $this->stateField : 'state';
    }
}