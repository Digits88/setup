<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 3/17/15
 * Time: 8:24 AM
 */

namespace AlfredNutileInc\CoreApp\SetUp\Steps;


use AlfredNutileInc\CoreApp\SetUp\SetupCommand;

abstract class BaseStep {

    protected function __construct()
    {

    }

   public static function fire(SetupCommand $setupCommand)
   {
       throw new \Exception("Method not implemented");
   }

}