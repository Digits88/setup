<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 3/17/15
 * Time: 8:23 AM
 */

namespace AlfredNutileInc\CoreApp\SetUp\Steps;


use AlfredNutileInc\CoreApp\SetUp\SetupCommand;
use Illuminate\Support\Facades\File;

class SetupFrontEnd extends BaseStep {


    public static function fire(SetupCommand $setupCommand)
    {
        $run = new self;
        $run->setupBower($setupCommand);
    }

    protected function setupBower(SetupCommand $setupCommand)
    {
        File::copy(base_path() . '/deployment/stubs/.bowerrc', base_path() . '/.bowerrc');
        File::copy(base_path() . '/deployment/stubs/bower.json', base_path() . '/bower.json');
        File::copy(base_path() . '/deployment/stubs/package.json', base_path() . '/package.json');
        $setupCommand->info("Added bower and bower.json.");
        exec('npm install');
        exec('bower install');
    }
}