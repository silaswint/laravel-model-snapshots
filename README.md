# Laravel model snapshots

# Why
When storing data, it is sometimes necessary to preserve the state of related models to ensure historical accuracy, even if the original models change over time.

This package provides an easy way to save the state of models as serialized model snapshots in a database table and automatically convert them into Eloquent models.

# Installation
You can install the package via composer:

```bash
composer require silaswint/laravel-model-snapshots
```

# Setup

## Migration

The following command will publish the migration file and run it automatically:

```bash
artisan model-snapshots:install
```

## Model

To enable snapshots for a model, the `HasSnapshots` trait must be registered:

```php
use Illuminate\Database\Eloquent\Model;
use Silaswint\LaravelModelSnapshots\App\Traits\HasSnapshots;
use App\Models;

class Order extends Model
{
    use HasSnapshots;
    
    public function user() {
        return $this->belongsTo(Models\User::class);
    }
    
    public function company() {
        return $this->belongsTo(Models\Company::class);
    }
    
    public function warehouses() {
        return $this->belongsToMany(Models\Warehouse::class);
    }
}
```

# Usage
To access the snapshot you can use the `latest_snapshot` or `first_snapshot` attribute. If you want to retrieve all snapshots, you can use the `snapshots()` method, which is a morphMany relationship.

```php
$order = Order::find(1);
$snapshot = $order->latest_snapshot; // or $order->first_snapshot, $order->snapshots()

$snapshotModel = $snapshot->stored_model; // returns App\Models\Order

$userSnapshot = $snapshotModel->user // returns App\Models\User
$companySnapshot = $snapshotModel->company // returns App\Models\Company
$warehousesSnapshot = $snapshotModel->warehouses // returns Illuminate\Database\Eloquent\Collection<App\Models\Warehouse>
```

To create a snapshot, use the `snapshot` helper function:

```php
use App\Models\Order;
use App\Models\Warehouse;

$order = Order::find(1);

snapshot(Order::find(1))
    ->setRelations(['user', 'company', 'warehouses'])
    ->commit();
```
> **Note:** `setRelations()` works like Laravel's `load()` function. If you don’t need to store relationships, you can omit it.
