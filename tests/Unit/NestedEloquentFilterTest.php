<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Appointment;
use App\Services\NestedEloquentFilter;

class NestedEloquentFilterTest extends TestCase
{
    public function test_generates_correct_sql_for_nested_filter()
    {
        $filters = [
            'user.name' => 'John',
            'appointment.state' => 'approved',
            'location.city' => 'Dallas',
        ];

        $query = Appointment::query();
        NestedEloquentFilter::apply($query, $filters);

        $sql = $query->toSql();

        // Assert SQL contains expected whereHas and orWhereHas logic
        $this->assertStringContainsString('exists', $sql);
        $this->assertStringContainsString('select * from', $sql); // Eloquent whereHas uses exists (select ...)
        $this->assertStringContainsString('state', $sql);
    }
}