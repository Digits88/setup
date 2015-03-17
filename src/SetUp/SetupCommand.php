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

class SetupCommand extends Command {

    protected $app_folder;
    protected $repo_name;
    protected $stubs      = 'stubs';
    protected $deployment = 'deployment';
    protected $deployment_destination = 'deployment';

    /**
     * @return string
     */
    public function getDeployment()
    {
        return $this->deployment;
    }

    /**
     * @param string $deployment
     */
    public function setDeployment($deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * @return string
     */
    public function getDeploymentDestination()
    {
        return $this->deployment_destination;
    }

    /**
     * @param string $deployment_destination
     */
    public function setDeploymentDestination($deployment_destination)
    {
        $this->deployment_destination = $deployment_destination;
    }


    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'core-app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Helps to setup a new App db and all';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(App::environment() == 'production')
        {
            $this->error("Production? Not sure if I can run this on production");
            exit();
        }
        $this->app_folder = base_path();
        $this->repo_name  = $this->argument('repo_name');

        SetupDeploymentScripts::fire($this);
        SetupEnv::fire($this);
        SetupDb::fire($this);
        RunMigrations::fire($this);
        SetupTesting::fire($this);
        SetupFrontEnd::fire($this);
        SetupServerConfig::fire($this);

    }

    public function getArguments()
    {
        return [
            ['repo_name', InputArgument::REQUIRED, "This is the name of the repo and will be the name of the local domain"]
        ];

    }

    /**
     * @return mixed
     */
    public function getAppFolder()
    {
        return $this->app_folder;
    }

    /**
     * @param mixed $app_folder
     */
    public function setAppFolder($app_folder)
    {
        $this->app_folder = $app_folder;
    }

    /**
     * @return mixed
     */
    public function getRepoName()
    {
        return $this->repo_name;
    }

    /**
     * @param mixed $repo_name
     */
    public function setRepoName($repo_name)
    {
        $this->repo_name = $repo_name;
    }

    /**
     * @return string
     */
    public function getStubs()
    {
        return $this->stubs;
    }

    /**
     * @param string $stubs
     */
    public function setStubs($stubs)
    {
        $this->stubs = $stubs;
    }
}