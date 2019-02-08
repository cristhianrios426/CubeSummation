<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TestCubeSummation;
/**
 * Proveedor de servicios para la sumatoria de cubos
 */
class CubeSummationProvider extends ServiceProvider
{	
	/**
	 * Registramos el proveedor de servicios. De este modo el controlador del
	 * cubo es injectable en todo el app
	 * 
	 * @return Void
	 */
	public function register(){
        $this->registerTestCubeSummation();
    }
	
    public function registerTestCubeSummation(){
    	$this->app->bind(TestCubeSummation::class, function ($app) {
            return new TestCubeSummation;
        });
    }
}