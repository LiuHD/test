<?php
/**
 * File name:read_zixishi_excel.php
 * Description:
 * Project:test
 * Created by LiuHD
 * Time:12:48 AM at 6/19/16
 */
require_once __DIR__ . '/../bootstrap.php';
$filePath = __DIR__ . '/../data/zixishi.xlsx';

$fileType = PHPExcel_IOFactory::identify($filePath); //文件名自动判断文件类型
$objReader = PHPExcel_IOFactory::createReader($fileType);
$objPHPExcel = $objReader->load($filePath);

$currentSheet = $objPHPExcel->getSheet(0); //第一个工作簿
$allRow = $currentSheet->getHighestRow(); //行数
$output = array();

//按照文件格式从第2行开始循环读取数据
//for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
//    //判断每一行的B列是否为有效的序号，如果为空或者小于之前的序号则结束
//    $xh = (int)$currentSheet->getCell('A' . $currentRow)->getValue();
//    if (empty($xh)) break;
//    $class_room = $currentSheet->getCell('B' . $currentRow)->getValue();
//    $zero_position = strpos($class_room, '0');
//    $jioaxuelou = substr($class_room, 0, $zero_position);
//    $jiaoshi = substr($class_room, $zero_position + 1);
//    for ($i = 1; $i < 6; $i++) {
//        $column = '';
//        $xingqiji = '';
//        switch ($i) {
//            case 1:
//                $column = 'C';
//                $xingqiji = '周一';
//                break;
//            case 2:
//                $xingqiji = '周二';
//                $column = 'D';
//                break;
//            case 3:
//                $xingqiji = '周三';
//                $column = 'E';
//                break;
//            case 4:
//                $xingqiji = '周四';
//                $column = 'F';
//                break;
//            case 5:
//                $xingqiji = '周五';
//                $column = 'G';
//                break;
//        }
//        $result = $currentSheet->getCell($column . $currentRow)->getValue();
//        if (strpos($result, '无') !== false) {
//            $output[$jioaxuelou][$jiaoshi][$xingqiji] = '';
//        } else {
//            $output[$jioaxuelou][$jiaoshi][$xingqiji] = $result;
//        }
//    }
//}


//$fp=fopen(__DIR__.'/../data/zixishi.json','w+');
//fwrite($fp,json_encode($output));
//fclose($fp);

$final_result = array();
//遍历周几
for ($i = 1; $i < 6; $i++) {
    $column = '';
    $xingqiji = '';
    switch ($i) {
        case 1:
            $column = 'C';
            $xingqiji = '周一';
            break;
        case 2:
            $xingqiji = '周二';
            $column = 'D';
            break;
        case 3:
            $xingqiji = '周三';
            $column = 'E';
            break;
        case 4:
            $xingqiji = '周四';
            $column = 'F';
            break;
        case 5:
            $xingqiji = '周五';
            $column = 'G';
            break;
    }
    //遍历每一个教室
    for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
        $result = $currentSheet->getCell($column . $currentRow)->getValue();
        if(strpos($result,'无')!==false){
            continue;
        }
        $value = explode('，',trim($result));
        foreach ($value as $item) {
            if(empty($item)){
                continue;
            }
            $underline_pos = strpos($item, '-');
            if ($underline_pos === false) {
                echo 'error 单元格' . $column . $currentRow . '中有不规律的记录出现,行'.__LINE__;
                exit;
            }
            if ((intval(substr($item, $underline_pos + 1)) - intval(substr($item, 0, $underline_pos))) > 1) {
                echo 'error 单元格' . $column . $currentRow . '中有不规律的记录出现,行'.__LINE__;
                exit;
            }
            $classroom = $currentSheet->getCell('B' . $currentRow)->getValue();
            $zero_position = strpos($classroom, '0');
            if ($zero_position === false) {
                echo 'error 单元格' . $columnx . $currentRow . '中有不规律的记录出现,行'.__LINE__;
                exit;
            }
            switch (intval(substr($item, 0, $underline_pos))) {
                case 1:
                    $final_result[$xingqiji]['上午第一节'][substr($classroom, 0, $zero_position)][] = substr($classroom, $zero_position + 1);
                    break;
                case 3:
                    $final_result[$xingqiji]['上午第二节'][substr($classroom, 0, $zero_position)][] = substr($classroom, $zero_position + 1);
                    break;
                case 5:
                    $final_result[$xingqiji]['下午第一节'][substr($classroom, 0, $zero_position)][] = substr($classroom, $zero_position + 1);
                    break;
                case 7:
                    $final_result[$xingqiji]['下午第二节'][substr($classroom, 0, $zero_position)][] = substr($classroom, $zero_position + 1);
                    break;
                case 9:
                    $final_result[$xingqiji]['晚上第一节'][substr($classroom, 0, $zero_position)][] = substr($classroom, $zero_position + 1);
                    break;
            }
        }
    }
}
var_dump($final_result);
$fp=fopen(__DIR__.'/../data/zixishi.json','w+');
fwrite($fp,json_encode($final_result,JSON_UNESCAPED_SLASHES));
fclose($fp);
exit;

