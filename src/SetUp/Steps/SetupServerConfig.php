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

class SetupServerConfig extends BaseStep
{


    public static function fire(SetupCommand $setupCommand)
    {
        $run = new self;
        $run->setupFolder($setupCommand);
        $run->setupLocalConfig($setupCommand);
        $run->setupNginx($setupCommand);
    }

    protected function setupLocalConfig(SetupCommand $setupCommand)
    {
        $contents = file_get_contents(base_path() . '/server_config/local.app.conf');
        $name = $setupCommand->getRepoName();
        $domain = $name . '.dev';
        $contents = str_replace(['REPO_NAME_DEV', 'REPO_NAME'], [$domain, $name], $contents);
        file_put_contents(base_path() . '/server_config/local.app.conf', $contents);
    }

    protected function setupFolder(SetupCommand $setupCommand)
    {
        File::copyDirectory(__DIR__ . '/../server_config', base_path() . '/server_config');
        $setupCommand->info("Server Config /server_config folder made");
    }

    private function setupNginx(SetupCommand $setupCommand)
    {

        $base = base_path() . '/server_config';
        $name = $setupCommand->getRepoName() . '.dev';
        $command = sprintf("sudo cp %s/local.app.conf /etc/nginx/sites-available/%s", $base, $name);
        exec($command);
        $setupCommand->info(sprintf("Copied file into nginx available %s", $name));

        $command = sprintf("sudo ln -s /etc/nginx/sites-available/%s /etc/nginx/sites-enabled/%s", $name, $name);
        exec($command);
        $setupCommand->info(sprintf("Symlinked file into nginx enabled %s", $name));

        exec("sudo /etc/init.d/nginx restart");
        $site = 'https://' . $setupCommand->getRepoName() . ':44300';

        $setupCommand->info(sprintf("Restarting Nginx you should now see the site at %s", $site));
        $setupCommand->info(sprintf("Make sure to set your /etc/hosts file locally for this site %s and 127.0.0.1", $site));
        $setupCommand->info(sprintf("SSL not setup? See docs https://github.com/alfred-nutile-inc/internal_practices/blob/master/ssl.md"));

    }
}
