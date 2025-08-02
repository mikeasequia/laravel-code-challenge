<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class ModelTransitioning
{
    use SerializesModels;

    public $model;
    public $from;
    public $to;

    public function __construct(Model $model, string $from, string $to)
    {
        $this->model = $model;
        $this->from = $from;
        $this->to = $to;
    }
}