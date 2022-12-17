<?php

namespace Controllers;

use Lawana\Controller\BaseController,
    Lawana\Utils\Request;
use Models\Example;

class ExampleController extends BaseController
{

    public function index(Request $request)
    {
        
        return view('home.welcome-page');
    }
}
