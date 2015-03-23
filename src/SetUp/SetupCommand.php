<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 3/17/15
 * Time: 6:56 AM
 */

namespace AlfredNutileInc\CoreApp\SetUp;


use AlfredNutileInc\CoreApp\SetUp\Steps\RunMigrations;
use AlfredNutileInc\CoreApp\SetUp\Steps\SetupDb;
use AlfredNutileInc\CoreApp\SetUp\Steps\SetupDeploymentScripts;
use AlfredNutileInc\CoreApp\SetUp\Steps\SetupEnv;
use AlfredNutileInc\CoreApp\SetUp\Steps\SetupFrontEnd;
use AlfredNutileInc\CoreApp\SetUp\Steps\SetupServerConfig;
use AlfredNutileInc\CoreApp\SetUp\Steps\SetupTesting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SetupCommand extends Command {

    protected $app_folder;
    protected $repo_name;
    protected $stubs      = 'stubs';
    protected $deployment = 'deployment';
    protected $deployment_destination = 'deployment';

    public function getDeployment()
    {
        return $this->deployment;
    }

    public function setDeployment($deployment)
    {
        $this->deployment = $deployment;
    }

    public function getDeploymentDestination()
    {
        return $this->deployment_destination;
    }

    public function setDeploymentDestination($deployment_destination)
    {
        $this->deployment_destination = $deployment_destination;
    }

    protected $name = 'core-app:setup';

    protected $description = 'Helps to setup a new App db and all. Use the --run option multiple times to choose what to run';


    /**
     *
     * Populates the Scripts to run help message so the person knows they
     * can run just your script
     * @var array
     */
    protected $scripts_to_run = [
        'SetupDeploymentScripts',
        'SetupEnv',
        'SetupDb',
        'RunMigrations',
        'SetupTesting',
        'SetupFrontEnd',
        'SetupServerConfig'
    ];

    public function handle()
    {
        if(App::environment() == 'production')
        {
            $this->error("Production? Not sure if I can run this on production");
            exit();
        }
        $this->app_folder = base_path();
        $this->repo_name  = $this->argument('repo_name');

        $this->runScripts();

    }

    protected function runScripts()
    {
        if($this->option('run'))
        {
            $to_run = $this->option('run');
        } else {
            $to_run = $this->scripts_to_run;
        }

        foreach($to_run as $run)
        {

            try
            {
                $class = __NAMESPACE__ . '\\Steps\\' . $run;
                $class::fire($this);
            }
            catch(\Exception $e)
            {
                throw new \Exception(sprintf("Error running %s", $e->getMessage()));
            }
        }
    }

    public function getOptions()
    {
        $description = implode(", ", $this->scripts_to_run);
        return [
            ['run', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, "Choose what methods to run eg {$description}"]
        ];
    }

    public function getArguments()
    {
        return [
            ['repo_name', InputArgument::REQUIRED, "This is the name of the repo and will be the name of the local domain"]
        ];
    }

    public function getAppFolder()
    {
        return $this->app_folder;
    }

    public function setAppFolder($app_folder)
    {
        $this->app_folder = $app_folder;
    }

    public function getRepoName()
    {
        return $this->repo_name;
    }

    public function setRepoName($repo_name)
    {
        $this->repo_name = $repo_name;
    }

    public function getStubs()
    {
        return $this->stubs;
    }

    public function setStubs($stubs)
    {
        $this->stubs = $stubs;
    }
}