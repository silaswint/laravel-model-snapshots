<?php

namespace Silaswint\LaravelModelSnapshots\App\Helper;

use Illuminate\Database\Eloquent\Model;

class Snapshot
{
    private ?array $relations = null;

    private Versionizer $versionizer;
    private ?string $description = null;
    private array $options = [];

    public function __construct(
        private readonly Model $model
    ) {
        $this->versionizer = Versionizer::make($this->model);
    }

    public static function make(Model $model): self
    {
        return new self($model);
    }

    /**
     * @param  array<int, string>  $relations  You can do things like `snapshot($model)->setRelations(['relation1', 'relation2.subRelation3'])->commit();`
     */
    public function setRelations(array $relations): self
    {
        $this->relations = array_merge($this->relations ?? [], $relations);

        return $this;
    }

    public function setVersionizer(Versionizer $versionizer): self
    {
        $this->versionizer = $versionizer;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * You can add any properties you want to the snapshot. If you want to search for a snapshot with a specific property, you can use the `options` column.
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function commit()
    {
        $storedModel = $this->model;

        if ($this->relations) {
            $storedModel->load($this->relations);
        }

        return config('model-snapshots.model')::create([
            'subject_type' => get_class($this->model),
            'subject_id' => $this->model->getKey(),
            'stored_model' => $storedModel,
            'version' => $this->versionizer->getVersion(),
            'options' => $this->options,
            'description' => $this->description,
        ]);
    }
}
