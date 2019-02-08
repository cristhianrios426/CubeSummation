<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TestCubeSummation;
use App\Exceptions\InputException;

class SumCube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sumcube {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta los tests dentro de archivo recibido';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    
    protected $tester;

    public function __construct(TestCubeSummation $tester)
    {
        parent::__construct();
        $this->tester = $tester;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('path');
        $this->tester->setInputFile($file);
        try {
            $this->tester->run();
            $this->info($this->tester->getOutput());  
        } catch (InputException $e) {
            $this->error($e->getMessage());
        }
        
    }
}
