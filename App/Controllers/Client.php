<?php

namespace App\Controllers;

use \Core\View;
use \App\Common;
use \App\Config;
use \App\Models\Task;

/**
* Client controller
*
* PHP version 5.6
*/
class Client extends \Core\Controller
{
    public function indexAction()
    {
        $smarty = View::getEngine();
        $smarty->display('index.html');
    }
}