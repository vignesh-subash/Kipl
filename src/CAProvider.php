<?php

namespace Kipl\Crmadmin;

use Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use Kipl\Crmadmin\Helpers\CAHelper;

class CAProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // @mkdir(base_path('resources/crmadmin'));
        // @mkdir(base_path('database/migrations/crmadmin'));
        /*
        $this->publishes([
            __DIR__.'/Templates' => base_path('resources/crmadmin'),
            __DIR__.'/config.php' => base_path('config/crmadmin.php'),
            __DIR__.'/Migrations' => base_path('database/migrations/crmadmin')
        ]);
        */
        //echo "Crmadmin Migrations started...";
        // Artisan::call('migrate', ['--path' => "vendor/kipl/crmadmin/src/Migrations/"]);
        //echo "Migrations completed !!!.";
        // Execute by php artisan vendor:publish --provider="Kipl\Crmadmin\CAProvider"

		/*
        |--------------------------------------------------------------------------
        | Blade Directives for Entrust not working in Laravel 5.3
        |--------------------------------------------------------------------------
        */
		if(CAHelper::laravel_ver() == 5.5) {

			// Call to Entrust::hasRole
			Blade::directive('role', function($expression) {
				return "<?php if (\\Entrust::hasRole({$expression})) : ?>";
			});

			// Call to Entrust::can
			Blade::directive('permission', function($expression) {
				return "<?php if (\\Entrust::can({$expression})) : ?>";
			});

			// Call to Entrust::ability
			Blade::directive('ability', function($expression) {
				return "<?php if (\\Entrust::ability({$expression})) : ?>";
			});
		}
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';

		// For CAEditor
		if(file_exists(__DIR__.'/../../laeditor')) {
			include __DIR__.'/../../laeditor/src/routes.php';
		}

        /*
        |--------------------------------------------------------------------------
        | Providers
        |--------------------------------------------------------------------------
        */

        // Collective HTML & Form Helper
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        // For Datatables
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        // For Gravatar
        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);
        // For Entrust
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);
        // For Spatie Backup
        $this->app->register(\Spatie\Backup\BackupServiceProvider::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Alias
        |--------------------------------------------------------------------------
        */

        $loader = AliasLoader::getInstance();

        // Collective HTML & Form Helper
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('HTML', \Collective\Html\HtmlFacade::class);

        // For Gravatar User Profile Pics
        $loader->alias('Gravatar', \Creativeorange\Gravatar\Facades\Gravatar::class);

        // For LaraAdmin Code Generation
        $loader->alias('CodeGenerator', \Kipl\Crmadmin\CodeGenerator::class);

        // For LaraAdmin Form Helper
        $loader->alias('CAFormMaker', \Kipl\Crmadmin\CAFormMaker::class);

        // For LaraAdmin Helper
        $loader->alias('CAHelper', \Kipl\Crmadmin\Helpers\CAHelper::class);

        // LaraAdmin Module Model
        $loader->alias('Module', \Kipl\Crmadmin\Models\Module::class);

		    // For LaraAdmin Configuration Model
		    $loader->alias('CAConfigs', \Kipl\Crmadmin\Models\CAConfigs::class);

        // For Entrust
		    $loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);
        $loader->alias('role', \Zizaco\Entrust\Middleware\EntrustRole::class);
        $loader->alias('permission', \Zizaco\Entrust\Middleware\EntrustPermission::class);
        $loader->alias('ability', \Zizaco\Entrust\Middleware\EntrustAbility::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Controllers
        |--------------------------------------------------------------------------
        */

        $this->app->make('\Kipl\Crmadmin\Controllers\ModuleController');
        $this->app->make('\Kipl\Crmadmin\Controllers\FieldController');
        $this->app->make('\Kipl\Crmadmin\Controllers\MenuController');

    		// For CAEditor
    		if(file_exists(__DIR__.'/../../laeditor')) {
    			$this->app->make('Kipl\Laeditor\Controllers\CodeEditorController');
    		}

    		/*
        |--------------------------------------------------------------------------
        | Blade Directives
        |--------------------------------------------------------------------------
        */

        // CAForm Input Maker
        Blade::directive('ca_input', function($expression) {
  			if(CAHelper::laravel_ver() == 5.5) {
  				$expression = "(".$expression.")";
  			}
        return "<?php echo CAFormMaker::input$expression; ?>";
        });

        // CAForm Form Maker
        Blade::directive('ca_form', function($expression) {
  			if(CAHelper::laravel_ver() == 5.5) {
  				$expression = "(".$expression.")";
  			}
            return "<?php echo CAFormMaker::form$expression; ?>";
        });

        // CAForm Maker - Display Values
        Blade::directive('ca_display', function($expression) {
			  if(CAHelper::laravel_ver() == 5.5) {
				  $expression = "(".$expression.")";
			  }
            return "<?php echo CAFormMaker::display$expression; ?>";
        });

        // CAForm Maker - Check Whether User has Module Access
        Blade::directive('ca_access', function($expression) {
  			if(CAHelper::laravel_ver() == 5.5) {
  				$expression = "(".$expression.")";
  			}
            return "<?php if(CAFormMaker::ca_access$expression) { ?>";
        });
        Blade::directive('endca_access', function($expression) {
            return "<?php } ?>";
        });

        // CAForm Maker - Check Whether User has Module Field Access
        Blade::directive('ca_field_access', function($expression) {
  			if(CAHelper::laravel_ver() == 5.5) {
  				$expression = "(".$expression.")";
  			}
            return "<?php if(CAFormMaker::ca_field_access$expression) { ?>";
        });
        Blade::directive('endca_field_access', function($expression) {
            return "<?php } ?>";
        });

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

		      $commands = [
            \Kipl\Crmadmin\Commands\Migration::class,
            \Kipl\Crmadmin\Commands\Crud::class,
            \Kipl\Crmadmin\Commands\Packaging::class,
            \Kipl\Crmadmin\Commands\CAInstall::class
        ];

    		// For CAEditor
    		if(file_exists(__DIR__.'/../../caeditor')) {
    			$commands[] = \Kipl\Caeditor\Commands\CAEditor::class;
    		}

            $this->commands($commands);
        }
}
