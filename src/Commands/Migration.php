<?php
/**
 * Code generated using CrmAdmin
 * Help: http://crmadmin.com
 * CrmAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Kipl
 * Developer Website: http://kipl.com
 */

namespace Kipl\Crmadmin\Commands;

use Illuminate\Console\Command;

use Kipl\Crmadmin\CodeGenerator;

/**
 * Class Migration
 * @package Kipl\Crmadmin\Commands
 *
 * Command to generation new sample migration file or complete migration file from DB Context
 * if '--generate' parameter is used after command, it generate migration from database.
 */
class Migration extends Command
{
    // The command signature.
    protected $signature = 'ca:migration {table} {--generate}';

    // The command description.
    protected $description = 'Generate Migrations for CrmAdmin';

    /**
     * Generate a Migration file either sample or from DB Context
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $generateFromTable = $this->option('generate');
        if($generateFromTable) {
            $generateFromTable = true;
        }
        CodeGenerator::generateMigration($table, $generateFromTable, $this);
    }
}
