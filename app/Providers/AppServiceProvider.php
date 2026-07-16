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
use Illuminate\Support\Facades\Vite;
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

        \Filament\Support\Facades\FilamentView::registerRenderHook(
            \Filament\View\PanelsRenderHook::BODY_END,
            fn (): string => '
                <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                <script src="https://js.pusher.com/8.0/pusher.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
                <script>
                    window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                    let token = document.head.querySelector(\'meta[name="csrf-token"]\');
                    if (token) {
                        window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
                    }
                    
                    window.Pusher = Pusher;
                    window.EchoFactory = Echo;
                    window.Echo = new Echo({
                        broadcaster: "pusher",
                        key: "w5blyrbctqcwxl0k87sr",
                        cluster: "mt1",
                        wsHost: window.location.hostname,
                        wsPort: 8080,
                        wssPort: 8080,
                        forceTLS: false,
                        disableStats: true,
                        enabledTransports: ["ws", "wss"],
                    });
                    window.dispatchEvent(new CustomEvent("EchoLoaded"));
                </script>
            ',
        );

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
                    ->sendToDatabase($users, true)
                    ->broadcast($users);
                
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
