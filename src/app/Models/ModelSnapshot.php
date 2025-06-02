<?php

namespace Silaswint\LaravelModelSnapshots\App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $stored_model
 * @property-read Model|\Eloquent $subject
 * @property int $version
 * @property array $options
 * @property string|null $description
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ModelSnapshot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelSnapshot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelSnapshot query()
 *
 * @mixin \Eloquent
 */
class ModelSnapshot extends Model
{
    protected $table = 'model_snapshots';

    protected $fillable = [
        'subject_type',
        'subject_id',
        'stored_model',
        'version',
        'options',
        'description',
    ];

    protected $casts = [
        'version' => 'integer',
        'options' => 'array',
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public function storedModel(): Attribute
    {
        return new Attribute(
            get: fn ($value) => unserialize($value),
            set: fn ($value) => serialize($value),
        );
    }
}
