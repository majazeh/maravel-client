<?php

namespace Maravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $breadcrumbs = config('breadcrumbs.files', [base_path('routes/breadcrumbs.php')]);
        Config::set('breadcrumbs.files', array_merge($breadcrumbs, [join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'routes', 'breadcrumbs.php'])]));
        $this->mergeConfigFrom(join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'config', 'users.php']), 'users');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Config::set('auth.defaults.guard', 'cookie');
        Config::set('auth.guards.cookie', [
            'driver' => 'cookie',
            'provider' => 'users'
        ]);
        if($this->app->request->header('x-forwarded-proto') == 'https')
        {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
        app('translation.loader')->addJsonPath(join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'lang']));
        Blade::directive('sortView', function ($args) {
            $args = explode(',', $args);
            $args[2] = isset($args[2]) ? $args[2] : 'null';
            $args[3] = isset($args[3]) ? $args[3] : 'null';
            return "<?php echo \$__env->make('components.sort', ['model' => $args[0], 'key' => $args[1], 'title' => ($args[2] ?: __(ucfirst($args[1]))), 'short_title' => $args[3]], [\Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])])->render(); ?>";
        });

        Blade::directive('id', function ($model) {
            return "<?php echo \$__env->make('components._id', ['model' => $model, 'id'=> ($model)->serial], [\Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])])->render(); ?>";
        });
        Blade::directive('mobile', function ($mobile) {
            return "<?php echo \$__env->make('components._mobile', ['mobile'=> App\Mobile::parse($mobile)], [\Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])])->render(); ?>";
        });
        Blade::directive('email', function ($email) {
            return "<?php echo \$__env->make('components._email', ['email'=> $email], [\Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])])->render(); ?>";
        });
        Blade::directive('username', function ($username) {
            return "<?php echo \$__env->make('components._username', ['username'=> $username], [\Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])])->render(); ?>";
        });
        Blade::directive('filterView', function ($args) {
            list($model, $key) = explode(',', $args);
            return "<?php echo \$__env->make('components._filter', ['model'=> $model, 'key' => $key], [\Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])])->render(); ?>";
        });
        Blade::directive('filterBadge', function ($model) {
            return "<?php echo \$__env->make('components._filterBadge', ['model'=> $model], [\Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])])->render(); ?>";
        });
        Blade::directive('termBadge', function ($term) {
            return "<?php echo \$__env->make('components._termBadge', ['term'=> $term], [\Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])])->render(); ?>";
        });
        Blade::directive('displayName', function ($user) {
            return "<?php echo e(($user)->name ?: ($user)->id) ?>";
        });
        Blade::directive('formValue', function ($model) {
            return "<?php echo isset($model) ? 'value=\"' . ($model) .'\"' : '' ?>";
        });
        Blade::directive('radioChecked', function ($args) {
            list($key, $value) = explode(',', $args);
            return "<?php echo isset($key) && $key == $value ? 'checked=\"checked\"' : ''?>";
        });
        Blade::directive('selectChecked', function ($args) {
            list($key, $value) = explode(',', $args);
            return "<?php echo isset($key) && $key == $value ? 'selected=\"selected\"' : ''?>";
        });
        Blade::directive('staticVersion', function ($file) {
            return "<?php echo $file . '?v='. filemtime(app()->basePath(join(DIRECTORY_SEPARATOR, ['public', rtrim($file, '/')])))?>";
        });
        Blade::directive('markdown', function ($content) {
            return "<?php echo (new \cebe\markdown\MarkdownExtra())->parse($content)?>";
        });

        Blade::directive('text2summary', function ($content) {
            return "<?php echo text2summary($content);?>";
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                join(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'assets']) => base_path()
            ]);
        }
        View::addLocation(join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'views']));
    }
}
