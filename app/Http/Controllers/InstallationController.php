<?php

namespace App\Http\Controllers;
use Artisan;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function migrate(){
        Artisan::call('migrate');
        return ['output' => Artisan::output()];
    }
    public function seed(){
        Artisan::call('db:seed');
        return ['output' => Artisan::output()];
    }
    public function symlink(){
        Artisan::call('storage:link');
        return ['output' => Artisan::output()];

    }
    public function postInstallation(){
        Artisan::call('key:generate');
        return ['output' => Artisan::output()];
    }
}
