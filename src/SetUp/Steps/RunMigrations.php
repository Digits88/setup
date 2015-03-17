<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 3/17/15
 * Time: 7:22 AM
 */

namespace AlfredNutileInc\CoreApp\SetUp\Steps;


use AlfredNutileInc\CoreApp\SetUp\SetupCommand;

class RunMigrations {

    protected function __construct()
    {

    }

    public static function fire(SetupCommand $setupCommand)
    {
        $run = new self;
        $run->migrate($setupCommand);
    }

    protected function migrate(SetupCommand $setupCommand)
    {

        $setupCommand->call('migrate:install');
        $setupCommand->info("Install Migrations");
        $setupCommand->call('migrate:refresh', ['--seed']);
        $setupCommand->info("Seeding Done");
    }
}