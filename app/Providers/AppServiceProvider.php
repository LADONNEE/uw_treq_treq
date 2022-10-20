<?php
namespace App\Providers;

use App\Utilities\PersonLookup;
use App\Utilities\SettingsCache;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PersonLookup::class, function(){
            return new PersonLookup();
        });
        $this->app->singleton(SettingsCache::class, function(){
            return new SettingsCache();
        });
    }

    public function boot()
    {

        URL::forceScheme('https');

        Blade::directive('orEmpty', function($expression) {
            return "<?php echo eOrEmpty($expression); ?>";
        });
        Blade::directive('icon', function($expression) {
            return "<?php \$_icon = $expression; echo \"<i class=\\\"fas fa-{\$_icon}\\\"></i>\"; ?>\n";
        });
        Blade::directive('bar', function() {
            return '<span class="mx-2" style="color:#ccc;">|</span>';
        });
        Blade::directive('setForm', function($expression) {
            return "<?php \$_f=$expression; ?>";
        });
        Blade::directive('input', function($expression) {
            return "<?php \$_f=\$_f ?? \$form; \$_iv=\$_f->inputView({$expression}); echo \$__env->make(\$_iv->view(), \$_iv->vars())->render(); ?>\n";
        });
        Blade::directive('inputBlock', function($expression) {
            return "<?php \$_f=\$_f ?? \$form; \$_iv=\$_f->inputView({$expression}); echo \$__env->make('inputs.block', \$_iv->vars())->render(); ?>\n";
        });
        Blade::directive('inputError', function($expression) {
            return "<?php \$_f=\$_f ?? \$form; \$_iv=\$_f->inputView({$expression}); echo \$__env->make('inputs.error', \$_iv->vars())->render(); ?>\n";
        });
        Blade::directive('projectNumber', function($expression) {
            return "<?php echo projectNumber($expression, true); ?>";
        });
    }
}
