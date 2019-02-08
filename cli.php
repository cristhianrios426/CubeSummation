<?php 
function opeationCubeUpdate($cube, $N ,$x, $y, $z, $W){
	$coors = [$x, $y, $z];
	
	$x = intval($x);
	$y = intval($y);
	$z = intval($z);	
	$cube[$x][$y][$z] = $W;
	return $cube;
}
function opeationCubeQuery($cube, $N ,$x1, $y1, $z1, $x2, $y2, $z2){
	$coors = [ "x"=>[$x1,$x2] ,"y"=>[$y1,$y2], "z"=>[$z1,$z2] ];
	
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

$stdin = fopen('php://stdin','r');
$T = intval(getLine($stdin));

for($t= 0; $t < $T; $t++){
	$line = getLine($stdin);
	if($line == "") break;
	$NM = explode(" ",$line);
	$N = intval($NM[0]);
	$M = intval($NM[1]);
	
	$cube = [];
	for($m = 0 ; $m < $M ; $m++){
		$line = getLine($stdin);
		$operationExploded = explode(' ', $line);
		$operationName = $operationExploded[0];		
		unset($operationExploded[0]);
		$args = array_values($operationExploded);
		array_unshift($args, $cube, $N);
		$operationFn = 'opeationCube'.ucfirst(strtolower($operationName));	
		$cube = call_user_func_array($operationFn, $args);		
	}
}

exit;