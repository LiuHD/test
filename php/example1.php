<?php
function isError($a,$m,$w){
	$sum=0.$standard=$m*$w;
	for($i=0;$i<$m,$i++){
		$sum=$a[$i]+$sum;
	}
	if($sum>$standard){
		return 1;
	}
	$i=0;
}