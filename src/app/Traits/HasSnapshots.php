<?php

namespace Silaswint\LaravelModelSnapshots\App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasSnapshots
{
    public function latestSnapshot(): Attribute
    {
        return new Attribute(
            get: fn () => $this->snapshots()->latest()->first(),
        );
    }

    public function firstSnapshot(): Attribute
    {
        return new Attribute(
            get: fn () => $this->snapshots()->oldest()->first(),
        );
    }

    public function snapshots()
    {
        return $this->morphMany(config('model-snapshots.model'), 'subject');
    }
}
