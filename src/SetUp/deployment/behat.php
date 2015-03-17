#!/usr/bin/php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

Dotenv::load(__DIR__ . '/../');

/**
 * @TODO build this from the yaml file on the fly
 */

$yml = new Symfony\Component\Yaml\Yaml();
$tests = $yml->parse(__DIR__ . '/../behat.yml');


$run = [];

$env = getenv('APP_ENV');

foreach($tests as $key => $test)
{

    if(strpos($key, $env) !== false)
    {
        $run[] = $key;
    }
}

$failing_test = [];


foreach($run as $test)
{
    $command = "bin/behat --stop-on-failure --no-paths --tags='@api,~@wip' --profile=$test";
    $run = new \Symfony\Component\Process\Process($command);
    $run->setTimeout(600);
    $run->run(function($type, $buffer) use ($failing_test, $test) {
        if(Symfony\Component\Process\Process::ERR ===  $type)
        {
            $failing_test[] = $test;
            //throw new \Exception(sprintf("Test Failed %s", $buffer));
        } else {
            echo $buffer;
        }
    });

    if($run->getExitCode() != 0) {
        $failing_test[] = $test;
    }

}

if (count($failing_test))
{
    $message = print_r($failing_test, 1);
    throw new \Exception(sprintf("Tests Failed the behat profiles are %s", $message));
}

