<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function task1(Request $request){
        return [
            "task" => '1'
        ];
    }

    public function task2(Request $request){
        return [
            "task" => '2'
        ];
    }
}
