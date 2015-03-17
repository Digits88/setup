<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 3/17/15
 * Time: 7:56 AM
 */

namespace AlfredNutileInc\CoreApp\SetUp\Steps;


use AlfredNutileInc\CoreApp\SetUp\SetupCommand;
use Illuminate\Support\Facades\File;

class SetupDeploymentScripts
{
    protected function __construct()
    {

    }

    public static function fire(SetupCommand $setupCommand)
    {
        $run = new self;
        File::copyDirectory(__DIR__ . '/../deployment', base_path() . '/deployment');
        $setupCommand->info("Deployment folder made");
    }
}
