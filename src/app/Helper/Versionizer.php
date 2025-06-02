<?php

namespace Silaswint\LaravelModelSnapshots\App\Helper;

readonly class Versionizer
{
    public function __construct(
        private \Illuminate\Database\Eloquent\Model $model
    ) {
    }

    public static function make(\Illuminate\Database\Eloquent\Model $model)
    {
        return new self($model);
    }

    public function getVersion(): int
    {
        $model = config('model-snapshots.model');
        $version = $model::where('subject_id', $this->model->id)
            ->where('subject_type', get_class($this->model))
            ->max('version');

        return (int) ($version ?? 0) + 1;
    }
}
