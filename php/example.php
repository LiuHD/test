<?php
function isError($a,$m,$w){
	$sum=0;
	$standard=$m*$w;
	for($i=0;$i<$m;$i++){
		$sum=$a[$i]+$sum;
	}
	if($sum>$standard){
		return 1;
	}
	$i=0;
	do{
		$sum=$sum-$a[$i]+$a[$m+$i+1];
		$i++;
		if ($sum>$standard){
			return 1;
		}
	}while ($m+$i+1<=count($a));
	return 0;
}

//special character includes =,;,\n,...
function store($a){
	$str='';
	foreach ($a as $item){
		if(is_array($item)){
			foreach ($item as $key=>$value){
				$str.=filter($key).'='.filter($value).';';
			}
			$str.='\n';
		}else{
			return 'Error:param is not an array';
		}
	}
	$path='';
	$fp=fopen($path,'w+');
	fwrite($fp,$str);
	fclose($fp);
}

function load($text){
	$arr=array();
	$pos=strpos('/n',$text);
	while ($pos!==false){
		$str=substr($text,0,$pos);
		$text=substr($text,$pos+1);
		preg_match($str,'/(?:!//);/',$matches);
		$a=[];
		foreach ($matches as $match){
			$a[substr($item, 0,strpos($item, '='))]=substr($item, strpos($item, '=')+1);
		}
		$arr[]=$a;
	}
}

function filter($str){
	return $str;
}
