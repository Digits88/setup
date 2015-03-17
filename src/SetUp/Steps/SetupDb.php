<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 3/17/15
 * Time: 7:22 AM
 */

namespace AlfredNutileInc\CoreApp\SetUp\Steps;


use AlfredNutileInc\CoreApp\SetUp\SetupCommand;

class SetupDb {

    protected function __construct()
    {

    }

    public static function fire(SetupCommand $setupCommand)
    {
        $run = new self;
        $run->setupDb($setupCommand);
    }

    protected function setupDB(SetupCommand $setupCommand)
    {
        $command = sprintf('mysql -uhomestead -psecret -e "create database %s"', $setupCommand->getRepoName());
        exec($command);
        $setupCommand->info(sprintf("Made db in homestead %s", $setupCommand->getRepoName()));
    }
}