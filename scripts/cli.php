<?php 
function operationCubeUpdate($cube, $N ,$x, $y, $z, $W){
	$coors = [$x, $y, $z];
	foreach ($coors as $value) {
		if($value <= 0 || $value > $N) throw new RunTimeException("Error de validación: Las coordenadas x, y y z deben estar entre 1 y $N. entrada actual: $x, $y, $z", 1);
	}
	if($W < -1000000000 || $W > 1000000000) throw new RunTimeException("Error de validación: El valor del bloque debe estar entre -10^9 y 10^9. entrada actual: $W", 1);
	$x = intval($x);
	$y = intval($y);
	$z = intval($z);	
	$cube[$x][$y][$z] = $W;
	return $cube;
}
function operationCubeQuery($cube, $N ,$x1, $y1, $z1, $x2, $y2, $z2){
	$coors = [ "x"=>[$x1,$x2] ,"y"=>[$y1,$y2], "z"=>[$z1,$z2] ];
	foreach ($coors as $key => $value) {
		if($value[0] > $value[1]) throw new RunTimeException("Error de validación: La coordenada {$key}1 debe ser mayor o igual a {$key}2. entrada actual: {$key}1 = {$value[0]}; {$key}2 = {$value[1]}", 1);
		if($value[0] > $N) throw new RunTimeException("Error de validación: La coordenada {$key}1 debe ser menor o igual a longitud de cubo: {$N}. entrada actual: {$value[0]}", 1);
		if($value[1] > $N) throw new RunTimeException("Error de validación: La coordenada {$key}2 debe ser menor o igual a longitud de cubo: {$N}. entrada actual: {$value[1]}", 1);
	}
	$sum = 0;
	foreach ($cube as $x => $cubex) {
		foreach ($cubex as $y => $cubey) {
			foreach ($cubey as $z => $cubez) {
				if(($x >= $x1 && $x <= $x2) && ($y >= $y1 && $y <= $y2) && ($z >= $z1 && $z <= $z2)){
					$sum += $cube[$x][$y][$z];
				}
			}
		}
	}
	echo $sum."\n";	
	return $cube;
}

function getLine($stdin){
	return str_replace(["\n", "  "], ["", " "], fgets($stdin));
}

try {

	$stdin = fopen('php://stdin','r');
	$T = intval(getLine($stdin));
	if($T <= 0 || $T > 50) throw new RunTimeException("Error de validación: El número de pruebas debe estar entre 1 y 50. entrada actual: $T", 1);

	for($t= 0; $t < $T; $t++){
		$line = getLine($stdin);
		if($line == "") break;
		$NM = explode(" ",$line);
		$N = intval($NM[0]);
		$M = intval($NM[1]);
		
		if($N <= 0 || $N > 100) throw new RunTimeException("Error de validación: La longitud del cubo debe estar entre 1 y 100. entrada actual: $N", 1);
		if($M <= 0 || $M > 1000) throw new RunTimeException("Error de validación: El número de operaciones debe estar entre 1 y 1000. entrada actual: $M", 1);

		$cube = [];
		for($m = 0 ; $m < $M ; $m++){
			$line = getLine($stdin);
			$operationExploded = explode(' ', $line);
			$operationName = $operationExploded[0];		
			unset($operationExploded[0]);
			$args = array_values($operationExploded);
			array_unshift($args, $cube, $N);
			$operationFn = 'operationCube'.ucfirst(strtolower($operationName));	
			if(!function_exists($operationFn))	if($m != $M) throw new RunTimeException("Error de validación: El número de operaciones ejectadas no coincide con las declaradas. ejecutadas: $m; declaradas: $M", 1);			
			$cube = call_user_func_array($operationFn, $args);		
		}
		if($m != $M) throw new RunTimeException("Error de validación: El número de operaciones ejectadas no coincide con las declaradas. ejecutadas: $m; declaradas: $M", 1);
	}
	if($t != $T) throw new RunTimeException("Error de validación: El número de pruebas ejectadas no coincide con las declaradas. ejecutadas: $t; declaradas: $T", 1);
} catch (RunTimeException $e) {
	echo $e->getMessage()."\n";
}
exit;