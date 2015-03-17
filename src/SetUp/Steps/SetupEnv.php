<?php namespace AlfredNutileInc\CoreApp\SetUp\Steps;


use AlfredNutileInc\CoreApp\SetUp\SetupCommand;

class SetupEnv {

    protected function __construct()
    {

    }

    public static function fire(SetupCommand $setupCommand)
    {
        $run = new self;
        $run->replaceDbName($setupCommand);
    }

    protected static function replaceDbName($setupCommand)
    {
        $contents = file_get_contents(__DIR__ . '/../' . $setupCommand->getStubs() . '/.env.example');

        $contents = str_replace('DB_DATABASE=homestead', 'DB_DATABASE=' . $setupCommand->getRepoName(), $contents);

        file_put_contents(base_path() . '/.env', $contents);

        $setupCommand->info(sprintf("Setup up .env to have settings"));
    }

}