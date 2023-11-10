<?php

namespace App\Controllers;

class Container extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Container',
        ];
        return view('container', $data);
    }
    public function index2()
    {
        $data = [
            'title' => 'Container',
        ];
        return view('container2', $data);
    }
}
