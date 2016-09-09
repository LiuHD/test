<?php 

 //将内容进行UNICODE编码
function unicode_encode($name)
{
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2)
    {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0)
        {    // 两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
        }
        else
        {
            $str .= $c2;
        }
    }
    return $str;
}

// 将UNICODE编码后的内容进行解码
function unicode_decode($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{3,4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2BE', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}


$ops = getopt('f:');
$json_file = $ops['f'];
if(empty($json_file)) {
    echo '参数为空！';
}

$json_data = json_decode(file_get_contents($json_file),true);
$json_data = array_reverse($json_data);
foreach ($json_data as $key => &$value) {
	foreach ($value as &$bill) {
		$bill['memo'] = unicode_decode($bill['memo']);
	}
}

$file_path = dirname($json_file) . '/' . pathinfo($json_file)['filename'] . '_decode.json';
@chmod(dirname($json_file) . '/', 0755);
$json_data = json_encode($json_data, 256);
//if(is_writeable($file_path)){
//    echo '可写' . PHP_EOL;
//    file_put_contents($file_path, $json_data);
//    echo '写入完毕' .  PHP_EOL;
//} else {
//    echo '不可写';
//}
//print_r($json_data);

file_put_contents($file_path, $json_data);
