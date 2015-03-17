<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 3/17/15
 * Time: 7:22 AM
 */

namespace AlfredNutileInc\CoreApp\SetUp\Steps;


use AlfredNutileInc\CoreApp\SetUp\SetupCommand;
use Illuminate\Support\Facades\File;

class SetupTesting {

    protected function __construct()
    {

    }

    public static function fire(SetupCommand $setupCommand)
    {
        $run = new self;
        $run->setupConfig($setupCommand);
        $run->setupDb($setupCommand);
    }

    protected function setupConfig(SetupCommand $setupCommand)
    {
        $contents = file_get_contents(base_path() . '/config/database.php');

        $contents = str_replace("'connections' => [", $this->dbSettings(), $contents);

        File::put(base_path() . '/config/database.php', $contents);

        exec("composer dump-autoload");


        $setupCommand->info("Testing db settings added");
    }

    protected function setupDB(SetupCommand $setupCommand)
    {
        if(File::exists(base_path() . '/database/stubdb.sqlite'))
        {
            File::delete(base_path() . '/database/stubdb.sqlite');
        }

        File::put(base_path() . '/database/stubdb.sqlite', '');

        if(File::exists(base_path() . '/database/testing.sqlite'))
        {
            File::delete(base_path() . '/database/testing.sqlite');
        }

        /**
         * @TODO Replace this with artisan command
         */
        $command = "sh " . base_path() . '/deployment/migrate_testing.sh';
        exec($command);
        File::copy(base_path() . '/database/stubdb.sqlite', base_path() . '/database/testing.sqlite');

        $setupCommand->info("Testing db info added");
    }



    protected function dbSettings()
    {

        return <<<HEREDOCS
'connections' => [
        'setup' => array(
            'driver' => 'sqlite',
            'database' => base_path().'/database/stubdb.sqlite',
            'prefix' => '',
        ),

        'sqlite' => array(
            'driver'   => 'sqlite',
            'database' => base_path() . '/database/testing.sqlite',
            'prefix'   => '',
        ),
HEREDOCS;
    }
}