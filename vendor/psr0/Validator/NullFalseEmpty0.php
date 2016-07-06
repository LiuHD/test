<?php
/**
 * Created by PhpStorm.
 * User: olive
 * Date: 9/11/15
 * Time: 3:53 PM
 * Motto:Best Wishes.
 */

// 判断 0 与 ''、null、empty、false 之间的关系
$a = 0;
echo "0 与 ''、 empty、null、false 之间的关系：";
if($a == ''){
    echo "0 == '';";
}else{
    echo "0 != '';";
}
if(trim($a) == ''){
    echo "trim(0) == '';";
}else{
    echo "trim(0) != '';";
}
if(strval($a) == ''){
    echo "strval(0) == '';";
}else{
    echo "strval(0) != '';";
}
if($a === ''){
    echo "0 === '';";
}else{
    echo "0 !=== '';";
}
if(empty($a)){
    echo "0 is empty;";
}else{
    echo "0 is not empty;";
}
if(is_null($a)){
    echo "0 is null;";
}else{
    echo "0 is not null;";
}
if(is_numeric($a)){
    echo "0 is numeric;";
}else{
    echo "0 is not numeric;";
}
if(is_string($a)){
    echo "0 is string;";
}else{
    echo "0 is not string;";
}
if(!$a){
    echo "0 is false;";
}else{
    echo "0 is not false;";
}
// 判断 '' 和 0、null、empty、false 之间的关系
$a = '';
echo "'' 和 0、empty、null、false 之间的关系：";
if($a == 0){
    echo "'' == 0;";
}else{
    echo "'' != 0;";
}
if(intval($a) == 0){
    echo "intval('') == 0;";
}else{
    echo "intval('') != 0;";
}
if(empty($a)){
    echo "'' is empty;";
}else{
    echo "'' is not empty;";
}
if(is_null($a)){
    echo "'' is null;";
}else{
    echo "'' is not null;";
}
if(is_numeric($a)){
    echo "'' is numeric;";
}else{
    echo "'' is not numeric;";
}
if(is_string($a)){
    echo "'' is string;";
}else{
    echo "'' is not string;";
}
if(!$a){
    echo "'' is false;";
}else{
    echo "'' is not false;";
}
// 判断 null 和 ''、0、empty、false 之间的关系
$a = null;
echo "null 和 ''、0、empty、false 之间的关系：";
if($a == ''){
    echo "null == '';";
}else{
    echo "null != '';";
}
if($a == 0){
    echo "null == 0;";
}else{
    echo "null != 0;";
}
if($a === ''){
    echo "null === '';";
}else{
    echo "null !=== '';";
}
if($a === 0){
    echo "null === 0;";
}else{
    echo "null !=== 0;";
}
if(strval($a) == ''){
    echo "strval(null) == '';";
}else{
    echo "strval(null) != '';";
}
if(intval($a) == 0){
    echo "intval(null) == 0;";
}else{
    echo "intval(null) != 0;";
}
if(empty($a)){
    echo "null is empty;";
}else{
    echo "null is not empty;";
}
if(is_numeric($a)){
    echo "null is numeric;";
}else{
    echo "null is not numeric;";
}
if(is_string($a)){
    echo "null is string;";
}else{
    echo "null is not string;";
}
if(!$a){
    echo "null is false;";
}else{
    echo "null is not false;";
}
echo "";

