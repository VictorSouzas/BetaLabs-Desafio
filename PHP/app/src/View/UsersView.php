<?php
namespace App\View;

use Cake\View\View;

class AppView extends View
{

    public function initialize()
    {
        // Always enable the MyUtils Helper
        $this->loadHelper('MyUtils');
        
    	$this->assign('title', 'Adicionando um novo usuario');

    }

    public function add(){    }

}