<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PolicyRule extends Model
{
    protected $fillable = ['action', 'rules', 'name', 'description', 'is_active'];
    
    protected $casts = [
        'rules' => 'array',
        'is_active' => 'boolean',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeForAction($query, string $action)
    {
        return $query->where('action', $action);
    }
}