<?php

namespace App\Services;

use App\Exceptions\InputException;
use App\Cube;

class TestCubeSummation{

	/**
	 * Determina si la fuente de datos es un string
	 * o un archivo
	 */
	protected $inputType;

	/**
	 * Almacena el input
	 * @var mix
	 */
	protected $input;	

	/**
	 * Almacena la salida
	 * @var string
	 */
	protected $output= "";	

	/**
	 * Almacena el indice actual en el recorrido del 
	 * @var integer
	 */
	protected $currentIndex = 0;

	/**
	 * modifica el método de entrada de datos
	 * @param string $string contiene los datos de entrada en string
	 */
	public function setInputString($string){		
		$this->input = explode("\n",$string);
		$this->currentIndex = 0;
		$this->type = 'string';
	}


	/**
	 * modifica el método de entrada de datos
	 * @param string $string contiene los datos de entrada en string
	 */
	public function setInputFile($path){
		$this->input = fopen($path, "r");
		$this->inputType = 'file';
	}

	/**
	 * Limplia la linea recibida
	 */
	public function clean($line){
		return str_replace(["\n", "  "], ["", " "], $line);
	}

	/**
	 * Devuelve la línea actual de la entrada de datos
	 * @return string
	 */
	public function getLine(){
		if($this->inputType == 'file'){
		
			$line = fgets($this->input) ;
			return empty($line) ? NULL : $this->clean( $line );
		}else{
			
			$i = $this->currentIndex;
			$this->currentIndex++;
			return !isset($this->input[$i]) ? NULL : $this->clean( $this->input[$i] ) ; 
		}
	}

	/**
	 * @param string añade contenido a la salida de datos
	 */
	public function addOutput($line){
		$this->output .= $line."\n";
	}

	/**
	 * Ejecuta los tests
	 * @return void
	 */
	public function run(){			
		$T = intval($this->getLine());
		if($T <= 0 || $T > 50) throw new InputException("Error de validación: El número de pruebas debe estar entre 1 y 50. entrada actual: $T", 1);
		for($t= 0; $t < $T; $t++){
			$line = $this->getLine();
			if($line == "") break;
			$NM = explode(" ",$line);
			$N = intval($NM[0]);
			$M = intval($NM[1]);
			
			if($N <= 0 || $N > 100) throw new InputException("Error de validación: La longitud del cubo debe estar entre 1 y 100. entrada actual: $N", 1);
			if($M <= 0 || $M > 1000) throw new InputException("Error de validación: El número de operaciones debe estar entre 1 y 1000. entrada actual: $M", 1);

			$cube = new Cube($N);
			for($m = 0 ; $m < $M ; $m++){
				$line = $this->getLine();
				$operationExploded = explode(' ', $line);
				$operationName = $operationExploded[0];		
				unset($operationExploded[0]);
				$args = array_values($operationExploded);					
				if($operationName == "UPDATE"){
					$cube->update(...$args);
				}elseif($operationName == "QUERY"){
					$this->addOutput($cube->query(...$args));
				}else{
					throw new InputException("Error de validación:Operación inválida. entrada: $operationName", 1);
				}
			}
			if($m != $M) throw new InputException("Error de validación: El número de operaciones ejectadas no coincide con las declaradas. ejecutadas: $m; declaradas: $M", 1);
		}
		if($t != $T) throw new InputException("Error de validación: El número de pruebas ejectadas no coincide con las declaradas. ejecutadas: $t; declaradas: $T", 1);		
	}

	public function getOutput(){
		return $this->output;
	}
}