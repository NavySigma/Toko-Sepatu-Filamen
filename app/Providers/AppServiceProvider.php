<?php

namespace App\Providers;

use App\Policies\ActivityPolicy;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    protected array $policies = [
        Activity::class => ActivityPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configurePolicies();

        $this->configureDB();

        $this->configureModels();

        $this->configureFilament();

        $this->configureLimit();

        \Illuminate\Support\Facades\Event::listen('eloquent.*', function (string $eventName, array $data) {
            // if (app()->runningInConsole()) return;

            if (!str_starts_with($eventName, 'eloquent.created: App\Models\\') && !str_starts_with($eventName, 'eloquent.updated: App\Models\\')) {
                return;
            }

            $model = $data[0] ?? null;
            if (!$model) return;

            if ($model instanceof \App\Models\User || 
                $model instanceof \Spatie\Activitylog\Models\Activity || 
                $model instanceof \Illuminate\Notifications\DatabaseNotification) {
                return;
            }

            $action = str_starts_with($eventName, 'eloquent.created') ? 'ditambahkan' : 'diperbarui';
            $modelName = class_basename($model);
            $nama = $model->nama ?? $model->name ?? '#' . $model->id;

            $users = \App\Models\User::role(['super_admin', 'admin_kasir'])->get();

            if ($users->isNotEmpty()) {
                \Filament\Notifications\Notification::make()
                    ->title("Data {$modelName} {$action}")
                    ->body("{$modelName} '{$nama}' berhasil {$action}.")
                    ->success()
                    ->sendToDatabase($users);
                
                \Illuminate\Support\Facades\Log::info("Notification sent for {$modelName}");
            }
        });
    }

    private function configurePolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    private function configureDB(): void
    {
        DB::prohibitDestructiveCommands($this->app->environment('production'));
    }

    private function configureModels(): void
    {
        Model::preventAccessingMissingAttributes();

        Model::unguard();
    }

    private function configureFilament(): void
    {
        FilamentShield::prohibitDestructiveCommands($this->app->isProduction());

        Column::configureUsing(fn (Column $column) => $column->toggleable());

        Table::configureUsing(fn (Table $table) => $table
            ->reorderableColumns()
            ->deferColumnManager(false)
            ->deferFilters(false)
            ->paginationPageOptions([10, 25, 50])
        );
    }

    private function configureLimit(): void
    {
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
    }
}
