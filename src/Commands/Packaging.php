<?php
/**
 * Command for LaraAdmin Package Development
 * Help: http://laraadmin.com
 */

namespace Kipl\Laraadmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Kipl\Crmadmin\Helpers\CAHelper;

class Packaging extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'crma:packaging';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = '[Developer Only] - Copy CRMAdmin-Dev files to package: "kipl/crmadmin"';

    protected $from;
    protected $to;

    var $modelsInstalled = ["User", "Role", "Permission", "Employee", "Department", "Upload", "Organization", "Backup"];

    /**
     * Generate a CRUD files inclusing Controller, Model and Routes
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Exporting started...');

        $from = base_path();
        $to = base_path('vendor/kipl/crmadmin/src/Installs');

        $this->info('from: '.$from." to: ".$to);

        // Controllers
        $this->line('Exporting Controllers...');
        $this->replaceFolder($from."/app/Http/Controllers/Auth", $to."/app/Controllers/Auth");
        $this->replaceFolder($from."/app/Http/Controllers/CA", $to."/app/Controllers/CA");
        $this->copyFile($from."/app/Http/Controllers/Controller.php", $to."/app/Controllers/Controller.php");
        $this->copyFile($from."/app/Http/Controllers/HomeController.php", $to."/app/Controllers/HomeController.php");

        // Models
        $this->line('Exporting Models...');

        foreach ($this->modelsInstalled as $model) {
            if($model == "User" || $model == "Role" || $model == "Permission") {
				$this->copyFile($from."/app/".$model.".php", $to."/app/Models/".$model.".php");
			} else {
				$this->copyFile($from."/app/Models/".$model.".php", $to."/app/Models/".$model.".php");
			}
        }

        // Routes
        $this->line('Exporting Routes...');
        if(CAHelper::laravel_ver() == 5.5) {
			// $this->copyFile($from."/routes/web.php", $to."/app/routes.php"); // Not needed anymore
			$this->copyFile($from."/routes/admin_routes.php", $to."/app/admin_routes.php");
		} else {
			// $this->copyFile($from."/app/Http/routes.php", $to."/app/routes.php"); // Not needed anymore
			$this->copyFile($from."/app/Http/admin_routes.php", $to."/app/admin_routes.php");
		}

		// tests
		$this->line('Exporting tests...');
		$this->replaceFolder($from."/tests", $to."/tests");

        // Config
        $this->line('Exporting Config...');
        $this->copyFile($from."/config/crmadmin.php", $to."/config/crmadmin.php");

        // la-assets
        $this->line('Exporting CrmAdmin Assets...');
        $this->replaceFolder($from."/public/la-assets", $to."/la-assets");
        // Use "git config core.fileMode false" for ignoring file permissions

        // migrations
        $this->line('Exporting migrations...');
        $this->replaceFolder($from."/database/migrations", $to."/migrations");

		// seeds
        $this->line('Exporting seeds...');
        $this->copyFile($from."/database/seeds/DatabaseSeeder.php", $to."/seeds/DatabaseSeeder.php");

        // resources
        $this->line('Exporting resources: assets + views...');
        $this->replaceFolder($from."/resources/assets", $to."/resources/assets");
        $this->replaceFolder($from."/resources/views", $to."/resources/views");

        // Utilities
        $this->line('Exporting Utilities...');
        // $this->copyFile($from."/gulpfile.js", $to."/gulpfile.js"); // Temporarily Not used.
    }

    private function replaceFolder($from, $to) {
        $this->info("replaceFolder: ($from, $to)");
        if(file_exists($to)) {
            CAHelper::recurse_delete($to);
        }
        CAHelper::recurse_copy($from, $to);
    }

    private function copyFile($from, $to) {
        $this->info("copyFile: ($from, $to)");
        //CAHelper::recurse_copy($from, $to);
        if(!file_exists(dirname($to))) {
            $this->info("mkdir: (".dirname($to).")");
            mkdir(dirname($to));
        }
        copy($from, $to);
    }
}
