<?php

namespace App\Observers;

use App\Models\Operator;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

class OperatorObserver
{
    public function created(Operator $operator): void
    {
        try {
            Cache::delete('operators_count');
        } catch (InvalidArgumentException) {
        }
    }

    public function updated(Operator $operator): void
    {
        //
    }

    public function deleted(Operator $operator): void
    {
        try {
            Cache::delete('operators_count');
        } catch (InvalidArgumentException) {
        }
    }

    public function restored(Operator $operator): void
    {
        //
    }

    public function forceDeleted(Operator $operator): void
    {
        //
    }
}
