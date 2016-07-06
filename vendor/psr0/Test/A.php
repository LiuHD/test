<?php

/**
 * File name:A.php
 * Description:
 * Project:test
 * Created by LiuHD
 * Time:10:59 AM at 3/14/16
 */
namespace Test;

class A
{
    public function congratulation(){
        echo 'You have successfully invoke autoload class functions,Congratulations!'.PHP_EOL;
        echo 'The directory of you computer is "'.DIRECTORY_SEPARATOR.'";'.PHP_EOL;
    }

}