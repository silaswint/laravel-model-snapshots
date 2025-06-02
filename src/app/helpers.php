<?php

if (! function_exists('snapshot')) {
    function snapshot(\Illuminate\Database\Eloquent\Model $model): \Silaswint\LaravelModelSnapshots\App\Helper\Snapshot
    {
        /** @var class-string<\Silaswint\LaravelModelSnapshots\App\Helper\Snapshot> $snapshot */
        $snapshot = config('model-snapshots.processor');

        return $snapshot::make($model);
    }
}
