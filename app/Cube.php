<?php 
namespace App;
use App\Exceptions\InputException;
/**
 * Describe los cubos usados en el proble
 */
class Cube {
	/**
	 * Longitud del lado del cubo
	 * @var integer
	 */
	protected $length = 0;

	/**
	 * Contiene los valores de bloques del cubo
	 * @var array
	 */
	protected $blocks = [];

	/**
	 * Contiene el rango min y max del valor de cada 
	 * bloque
	 * @var array
	 */
	protected $range = [-1000000000, 1000000000];


	public function __construct($length){
		$this->setLength($length);
	}

	/**
	 * Setea el valor de static::length
	 * @param Integer $length 
	 */
	public function setLength($length){
		$this->length=$length;
	}

	/**
	 * Actualiza el valor de un bloque dadas las coordenadas
	 * @param  integer $x entero mayor que 0 y menos que static::length. coordenad en x
	 * @param  integer $y entero mayor que 0 y menos que static::length. coordenad en y
	 * @param  integer $z entero mayor que 0 y menos que static::length. coordenad en z	 
	 * @param  integer $W valor para actualizar el bloque
	 *
	 * @return   void
	 */
	public function update($x, $y, $z, $W){
		$coors = [$x, $y, $z];
		foreach ($coors as $value) {
			if($value <= 0 || $value > $this->length) throw new InputException("Error de validación: Las coordenadas x, y y z deben estar entre 1 y {$this->length}. entrada actual: $x, $y, $z");
		}
		if($W < $this->range[0] || $W > $this->range[1]) throw new InputException("Error de validación: El valor del bloque debe estar en el rango ( ".implode(', ',$this->range)." )");
		
		$x = intval($x);
		$y = intval($y);
		$z = intval($z);	
		$this->blocks[$x][$y][$z] = $W;		
	}

	/**
	 * Devuelve el valor de la sumatoria del area seleccionada a partir de las
	 * coordenadas
	 * 
	 * @param  integer $x1 entero mayor que 0 y menos que static::length.
	 * @param  integer $y1 entero mayor que 0 y menos que static::length.
	 * @param  integer $z1 entero mayor que 0 y menos que static::length.
	 * @param  integer $x2 entero mayor que 0 y menos que static::length.
	 * @param  integer $y3 entero mayor que 0 y menos que static::length.
	 * @param  integer $z3 entero mayor que 0 y menos que static::length.
	 *
	 * @return   void
	 */
	public function query($x1, $y1, $z1, $x2, $y2, $z2){
		$coors = [ "x"=>[$x1,$x2] ,"y"=>[$y1,$y2], "z"=>[$z1,$z2] ];
		foreach ($coors as $key => $value) {
			if($value[0] > $value[1]) throw new InputException("Error de validación: La coordenada {$key}1 debe ser mayor o igual a {$key}2. entrada actual: {$key}1 = {$value[0]}; {$key}2 = {$value[1]}", 1);
			if($value[0] > $this->length) throw new InputException("Error de validación: La coordenada {$key}1 debe ser menor o igual a longitud de cubo: {$this->length}. entrada actual: {$value[0]}", 1);
			if($value[1] > $this->length) throw new InputException("Error de validación: La coordenada {$key}2 debe ser menor o igual a longitud de cubo: {$this->length}. entrada actual: {$value[1]}", 1);
		}
		$sum = 0;
		$cube = $this->blocks;
		foreach ($cube as $x => $cubex) {
			foreach ($cubex as $y => $cubey) {
				foreach ($cubey as $z => $cubez) {
					if(($x >= $x1 && $x <= $x2) && ($y >= $y1 && $y <= $y2) && ($z >= $z1 && $z <= $z2)){
						$sum += $cube[$x][$y][$z];
					}
				}
			}
		}		
		return $sum;
	}
}