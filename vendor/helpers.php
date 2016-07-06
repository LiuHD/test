<?php
/**
 * File name:helpers.php
 * Description:
 * Project:test
 * Created by LiuHD
 * Time:3:11 PM at 4/1/16
 */

if (!function_exists('write_to_log')) {
    function write_to_log($str)
    {
        if ($fd = @fopen(__DIR__.'/../tmp/my-errors.log', "a")) {
            fputs($fd, $str);
            fclose($fd);
        }
    }
}

if (!function_exists('get_var')) {
    function get_var($name, $default)
    {
        if ($var = getenv($name)) {
            return $var;
        } else {
            return $default;
        }
    }
}

if (!function_exists('log_to_file')) {
    function log_to_file()
    {
        //用户定义变量
        $logfile = "clf.log"; //LOG文件名
        $timezone = "+0100";
        $lookup_size = true; //设置文件权限
        $document_root = "/htdocs";//log存储路径
        //要对$document_root进行设置

        if ($remote_host = get_var("REMOTE_HOST", false)) {
            $remote_host = get_var("REMOTE_ADDR", "-");
        }
        $remote_user = get_var("REMOTE_USER", "-");
        $remote_ident = get_var("REMOTE_IDENT", "-");
        $server_port = get_var("SERVER_PORT", 80);
        if ($server_port != 80) {
            $server_port = ":" . $server_port;
        } else {
            $server_port = "";
        }
        $server_name = get_var("SERVER_NAME", "-");
        $request_method = get_var("REQUEST_METHOD", "GET");
        $request_uri = get_var("REQUEST_URI", "");
        $user_agent = get_var("HTTP_USER_AGENT", "");
        if ($lookup_size == true && $document_root) {
            $filename = ereg_replace("\?.*", "", $request_uri);
            $filename = "$document_root$filename";
            if (!$size = filesize($filename)) {
                $size = 0;
            }
        } else {
            $size = 0;
        }
        $date = gmdate("d/M/Y:H:I:s");
        $log = "$remote_host $remote_ident $remote_user [$date $timezone] \"" .
            "$request_method http://$server_name$server_port$request_uri\" 200 $size\n";
        write_to_log($log);
    }
}

if(!function_exists('my_error_handler')){
    function my_error_handler($error_level,$error_messages,$error_file,$error_line,$error_context){
        write_to_log(PHP_EOL.$error_level.' : '.$error_messages.' In '.$error_file.' LINE '.$error_line);
        if($error_level!=E_STRICT){
            die('Something Unexpected Happened!</b>');
        }
    }
    set_error_handler('my_error_handler',E_ALL|E_STRICT|E_COMPILE_ERROR|E_RECOVERABLE_ERROR);
}

if(!function_exists('my_exception_handler')){
    function my_exception_handler($exception){
            die('I have catched you!</b>');
    }
    set_exception_handler('my_exception_handler');
}
