<?php
/**
 * File name:hsdzzxy.php
 * Description:
 * Project:test
 * Created by LiuHD
 * Time:12:20 PM at 5/28/12
 */
//装在模板文件
include_once("wx_tpl.php");
include_once("base-class.php");
include_once("getXiaoiInfo.php");
include_once("getTulingResp.php");

//新建sae数据库类
$mysql = new SaeMysql();

//新建缓存引擎Memcache类
$mc = memcache_init();

$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

if (!empty($postStr)) {
    //解析数据
    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    //发送方Id
    $fromUsername = $postObj->FromUserName;
    //接收方Id
    $toUsername = $postObj->ToUserName;
    //消息类型
    $form_MsgType = $postObj->MsgType;

    /**
     * 事件消息
     **/

    if ($form_MsgType == "event")         //关注欢迎词
    {
        //获取事件类型
        $form_Event = $postObj->Event;
        //订阅事件
        if ($form_Event == "subscribe") {
            //回复欢迎文字消息
            $msgType = "text";
            $contentStr = "欢迎关注\n[玫瑰]河师大掌中校园[玫瑰]\n-----使用帮助-----\n回复“入学指南”查看《新生入学指南》\n----\n回复“自习室”或[奋斗]表情开始查询自习室\n----\n回复“公选课”加关键字\n如\"公选课幸福\"查看《幸福学》课程信息\n----\n回复“点歌”加歌名\n如\"点歌稻香\"收听《稻香》";
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
            //sprintf() 函数把格式化的字符串写入一个变量中。
            echo $resultStr;
            exit;
        }
    }

    /**
     * 文字消息
     */
    else if ($form_MsgType == "text") {
        $textContent = $postObj->Content;
        $textContent = trim($textContent);
        if (!empty($textContent)) {
            //从memcache获取用户上一次动作
            $last_do = $mc->get($fromUsername . "_do");
            //从memcache获取用户上一次数据
            $whichBuilding = $mc->get($fromUsername . "_whichBuilding");
            $weekday = $mc->get($fromUsername . "_weekday");

            //关键字识别
            if ($textContent == "帮助")   //帮助
            {
                $msgType = "text";
                $contentStr = "河师大掌中校园使用帮助\n-------------\n回复【入学指南】查看《新生入学指南》\n----\n回复【自习室】或[奋斗]表情开始查询自习室\n----\n回复【公选课】加关键字\n如\"公选课幸福\"查看《幸福学》课程信息\n----\n回复【点歌+歌名】如\"点歌稻香\"收听《稻香》\n--------\n你还可以回复任意关键字跟我聊天哦，无节操无下限，有问必答！(≧▽≦)
          <a href=\"http://www.henannu.edu.cn/#\">校园网</a> <a href=\"http://www.htu.cn/datongshe/\">大通社</a>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                echo $resultStr;
                exit;
            }
            else if ($textContent == "/:,@f" || $textContent == "自习室") //自习室
                {
                $mc->set($fromUsername . "_do", "zxs_0", 0, 1200);
                $msgType = "text";
                $contentStr = "请回复数字选择教学楼：\n1.田家炳\n2.二号楼\n3.文科楼\n4.阶梯楼\n5.东区A楼\n6.东区B楼";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                echo $resultStr;
                exit;
            }
            if (is_numeric($textContent)) {
                if (strlen($textContent) == 3) {
                    $num = intval($textContent);
                    $textContent = $num % 10;
                    $xingqi = floor(($num % 100) / 10);
                    if ($xingqi == "1") {
                        $weekday = "一";
                        $mc->set($fromUsername . "_weekday", "一", 0, 800);
                    } else if ($xingqi == "2") {
                        $weekday = "二";
                        $mc->set($fromUsername . "_weekday", "二", 0, 800);
                    } else if ($xingqi == "3") {
                        $weekday = "三";
                        $mc->set($fromUsername . "_weekday", "三", 0, 800);
                    } else if ($xingqi == "4") {
                        $weekday = "四";
                        $mc->set($fromUsername . "_weekday", "四", 0, 800);
                    } else if ($xingqi == "5") {
                        $weekday = "五";
                        $mc->set($fromUsername . "_weekday", "五", 0, 800);
                    } else {
                        $msgType = "text";
                        $contentStr = "error 星期几代号错误，请重新输入1-5之间的数字\n如需帮助，请回复“帮助”";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                        echo $resultStr;
                        exit;
                    }

                    $jiaoshi = floor($num / 100);  //教室
                    if ($jiaoshi == "1") {
                        $whichBuilding = "田家炳";
                        $mc->set($fromUsername . "_whichBuilding", "田家炳", 0, 1000);
                    } else if ($jiaoshi == "2") {
                        $whichBuilding = "二号楼";
                        $mc->set($fromUsername . "_whichBuilding", "二号楼", 0, 1000);
                    } else if ($jiaoshi == "3") {
                        $whichBuilding = "文科楼";
                        $mc->set($fromUsername . "_whichBuilding", "文科楼", 0, 1000);
                    } else if ($jiaoshi == "4") {
                        $whichBuilding = "阶梯楼";
                        $mc->set($fromUsername . "_whichBuilding", "阶梯楼", 0, 1000);
                    } else if ($jiaoshi == "5") {
                        $whichBuilding = "东区A楼";
                        $mc->set($fromUsername . "_whichBuilding", "东区A楼", 0, 1000);
                    } else if ($jiaoshi == "6") {
                        $whichBuilding = "东区B楼";
                        $mc->set($fromUsername . "_whichBuilding", "东区B楼", 0, 1000);
                    } else {
                        $msgType = "text";
                        $contentStr = "error 教学楼编号错误，应输入1-6之间的数字\n如需帮助，请回复“自习室”";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                        echo $resultStr;
                        exit;
                    }
                    $last_do = "zxs_2";
                }
                else if (strlen($textContent) == 1) {
                    if ($last_do == "zxs_0")      //选择教学楼
                    {
                        $mc->set($fromUsername . "_do", "zxs_1", 0, 600);
                        if ($textContent == "1") {
                            $mc->set($fromUsername . "_whichBuilding", "田家炳", 0, 1000);
                        } else if ($textContent == "2") {
                            $mc->set($fromUsername . "_whichBuilding", "二号楼", 0, 1000);
                        } else if ($textContent == "3") {
                            $mc->set($fromUsername . "_whichBuilding", "文科楼", 0, 1000);
                        } else if ($textContent == "4") {
                            $mc->set($fromUsername . "_whichBuilding", "阶梯楼", 0, 1000);
                        } else if ($textContent == "5") {
                            $mc->set($fromUsername . "_whichBuilding", "东区A楼", 0, 1000);
                        } else if ($textContent == "6") {
                            $mc->set($fromUsername . "_whichBuilding", "东区B楼", 0, 1000);
                        } else {
                            $mc->set($fromUsername . "_do", "zxs_0", 0, 600);
                            $msgType = "text";
                            $contentStr = "error 请输入1-6之间的数字\n如需帮助，请回复“帮助”";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                            echo $resultStr;
                            exit;
                        }
                        $msgType = "text";
                        $contentStr = "请回复数字选择星期几：\n1.周一\n2.周二\n3.周三\n4.周四\n5.周五";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                        echo $resultStr;
                        exit;
                    }

                    else if ($last_do == "zxs_1")     //选择星期几
                    {
                        $mc->set($fromUsername . "_do", "zxs_2", 0, 600);
                        if ($textContent == "1") {
                            $mc->set($fromUsername . "_weekday", "one", 0, 800);
                        } else if ($textContent == "2") {
                            $mc->set($fromUsername . "_weekday", "two", 0, 800);
                        } else if ($textContent == "3") {
                            $mc->set($fromUsername . "_weekday", "three", 0, 800);
                        } else if ($textContent == "4") {
                            $mc->set($fromUsername . "_weekday", "four", 0, 800);
                        } else if ($textContent == "5") {
                            $mc->set($fromUsername . "_weekday", "five", 0, 800);
                        } else {
                            $mc->set($fromUsername . "_do", "zxs_1", 0, 600);
                            $msgType = "text";
                            $contentStr = "error 请重新输入1-5之间的数字\n如需帮助，请回复“帮助”";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                            echo $resultStr;
                            exit;
                        }
                        $msgType = "text";
                        $contentStr = "请回复数字选择第几节课：\n1.上午第一节[1-2]\n2.上午第二节[3-4]\n3.下午第一节[5-6]\n4.下午第二节[7-8]\n5.晚上第一节[9-10]";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                        echo $resultStr;
                        exit;
                    }
                } else {
                    $msgType = "text";
                    $contentStr = "error\n 如果不清楚查询自习室如何操作，请回复“帮助”";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                if ($last_do == "zxs_2")    //选择第几节，后期处理
                {
                    if ($textContent == "1") {
                        $daytime = "一";
                    } else if ($textContent == "2") {
                        $daytime = "二";
                    } else if ($textContent == "3") {
                        $daytime = "三";
                    } else if ($textContent == "4") {
                        $daytime = "四";
                    } else if ($textContent == "5") {
                        $daytime = "五";
                    } else {
                        $mc->set($fromUsername . "_do", "zxs_2", 0, 600);
                        $msgType = "text";
                        $contentStr = "error 选择第几节课应该输入1-5之间的数字，请重新输入\n 如需帮助，请回复“帮助”";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                        echo $resultStr;
                        exit;
                    }
                    //weekday----星期几
                    //daytime----第几节课


                    $zxss = $mysql->getData("
                        select jiaoshi from zixishi16 where jiaoshi like '%".$whichBuilding."%' and $weekday like '%".$daytime."%'"
                    );

                    if(!is_array($zxss)){
                        $msgType = "text";
                        $contentStr = strval($zxss).$mysql->error();
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                        echo $resultStr;
                        exit;
                    }
                    if (is_array($zxss) && count($zxss)==0) {
                        $msgType = "text";
                        $contentStr = "无空闲教室[委屈]\n如需帮助，请回复“帮助”\n-----\n" . $whichBuilding . "星期" . $weekday . $daytime . "节\n偷偷的告诉你:即日起可以回复任意关键字跟我聊天哦，无节操无下限，有问必答！速来赐教(≧▽≦)";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                        echo $resultStr;
                        exit;
                    }
                    $contentStr = "空闲教室有";
                    foreach ($zxss as $zxs) {
                        $contentStr.= substr($zxs['jiaoshi'],-3).",";
                    }

                    $quotes=array(
                    "\n本学期自习室课表已更新完全，请同学们放心使用！^ω^",
                    "\n偷偷的告诉你:即日起可以回复任意关键字跟我聊天哦，无节操无下限，有问必答！速来赐教(≧▽≦)",
                    "\n喜欢我们的自习室查询功能么，想带动你身边更多的人和你一起自习么，那就快推荐给身边的人关注吧",
                    "\n点歌功能是个很好玩的功能哦，赶快试试回复【点歌+歌名】如\"点歌稻香\"试试吧"
                );
                    $rand = rand(1, 20);
                    if(count($quotes)>$rand){
                        $insertStr=$quotes[$rand];
                    }else{
                        $insertStr='';
                    }
                    switch($weekday){
                        case 'one':
                            $weekday='一';
                            break;
                        case 'two':
                            $weekday='二';
                            break;
                        case 'three':
                            $weekday='三';
                            break;
                        case 'four':
                            $weekday='四';
                            break;
                        case 'five':
                            $weekday='五';
                            break;
                    }
                    switch($daytime){
                        case '一':
                            $daytime='上午第一节';
                            break;
                        case '二':
                            $daytime='上午第二节';
                            break;
                        case '三':
                            $daytime='下午第一节';
                            break;
                        case '四':
                            $daytime='下午第二节';
                            break;
                        case '五':
                            $daytime='晚自习';
                            break;
                    }

                    $contentStr = substr($contentStr,0,strlen($contentStr)-1) . "\n-----\n[奋斗]" . $whichBuilding . "星期" . $weekday . $daytime . "节" . $insertStr;
                    $msgType = "text";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
            }
            else if ($textContent == "丫头")      //丫头专属
            {
                $msgType = "text";
                $contentStr = "死生契阔 与子成说\n执子之手 与子偕老\n             [爱情]";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                echo $resultStr;
                exit;
            }
            else if ($textContent == "潘丽苹")      //丫头专属
            {
                $msgType = "text";
                $contentStr = "我媳妇！\n    [爱情]";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                echo $resultStr;
                exit;
            }
            else if ($textContent == "入学指南")      //入学指南
            {
                $mc->set($fromUsername . "_do", "fy_0", 0, 600);
                $msgType = "news";
                $ArticleCount = "5";
                $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, $ArticleCount);

                $Title1 = "河师大新生入学指南";
                $Discription1 = "";
                $PicUrl1 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/201308010023.png";
                $Url1 = "";
                $item1 = sprintf($itemTpl, $Title1, $Discription1, $PicUrl1, $Url1);

                $Title2 = "一、新生入学篇";
                $Discription2 = "";
                $PicUrl2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                $Url2 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000016&itemidx=1&sign=6561122042d8ea3f7e2d57f5dfb185d9#wechat_redirect";
                $item2 = sprintf($itemTpl, $Title2, $Discription2, $PicUrl2, $Url2);

                $Title3 = "二、入校购物篇";
                $Discription3 = "";
                $PicUrl3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                $Url3 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000021&itemidx=1&sign=dc72f8b504de981813859aac63f3ffc0#wechat_redirect";
                $item3 = sprintf($itemTpl, $Title3, $Discription3, $PicUrl3, $Url3);

                $Title4 = "三、关于助学贷款";
                $Discription4 = "";
                $PicUrl4 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                $Url4 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000026&itemidx=1&sign=a6c69419b5b04d1d8118c5afb8b59778#wechat_redirect";
                $item4 = sprintf($itemTpl, $Title4, $Discription4, $PicUrl4, $Url4);

                $Title5 = "回复“fy”看下一页\n回复“帮助”查看帮助";
                $Discription5 = "";
                $PicUrl5 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/fanyetubiao.png";
                $Url5 = "";
                $item5 = sprintf($itemTpl, $Title5, $Discription5, $PicUrl5, $Url5);

                $resultStr = $news_fore . $item1 . $item2 . $item3 . $item4 . $item5 . $news_end;

                echo $resultStr;
                exit;
            }
            else if ($textContent == "fy")     //翻页
            {
                if ($last_do == "fy_0")  //第一次翻页
                {
                    $mc->set($fromUsername . "_do", "fy_1", 0, 600);
                    $msgType = "news";
                    $ArticleCount = "5";
                    $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, $ArticleCount);


                    $Title1 = "河师大新生入学指南";
                    $Discription1 = "";
                    $PicUrl1 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/201308010023.png";
                    $Url1 = "";
                    $item1 = sprintf($itemTpl, $Title1, $Discription1, $PicUrl1, $Url1);

                    $Title2 = "四、关于吃饭";
                    $Discription2 = "";
                    $PicUrl2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                    $Url2 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000026&itemidx=2&sign=61526b341798b62c487811eeebc37461#wechat_redirect";
                    $item2 = sprintf($itemTpl, $Title2, $Discription2, $PicUrl2, $Url2);

                    $Title3 = "五、关于图书馆和教学楼和校区";
                    $Discription3 = "";
                    $PicUrl3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                    $Url3 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000026&itemidx=3&sign=8e2c81377de1d0566ed82c243cca2e79#wechat_redirect";
                    $item3 = sprintf($itemTpl, $Title3, $Discription3, $PicUrl3, $Url3);

                    $Title4 = "六、公交和银行系列";
                    $Discription4 = "";
                    $PicUrl4 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                    $Url4 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000026&itemidx=4&sign=0652bed5f7a513185565d7f291bfe80e#wechat_redirect";
                    $item4 = sprintf($itemTpl, $Title4, $Discription4, $PicUrl4, $Url4);

                    $Title5 = "回复“fy”查看最后一页\n回复“帮助”查看帮助";
                    $Discription5 = "";
                    $PicUrl5 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/fanyetubiao.png";
                    $Url5 = "";
                    $item5 = sprintf($itemTpl, $Title5, $Discription5, $PicUrl5, $Url5);

                    $resultStr = $news_fore . $item1 . $item2 . $item3 . $item4 . $item5 . $news_end;
                    $return = new Saestorage;
                    $return->write('hsdzzxy', 'text.txt', $resultStr);
                    echo $resultStr;
                    exit;
                }

                if ($last_do == "fy_1")  //第二次翻页
                {
                    //清空memcache动作
                    $mc->delete($fromUsername . "_do");
                    $msgType = "news";
                    $ArticleCount = "4";
                    $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, $ArticleCount);


                    $Title1 = "河师大新生入学指南";
                    $Discription1 = "";
                    $PicUrl1 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/201308010023.png";
                    $Url1 = "";
                    $item1 = sprintf($itemTpl, $Title1, $Discription1, $PicUrl1, $Url1);

                    $Title2 = "七、社团推荐";
                    $Discription2 = "";
                    $PicUrl2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                    $Url2 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000038&itemidx=1&sign=6bdace6dbd99fdc7cbbb63a0072cb79d#wechat_redirect";
                    $item2 = sprintf($itemTpl, $Title2, $Discription2, $PicUrl2, $Url2);

                    $Title3 = "八、周末出行";
                    $Discription3 = "";
                    $PicUrl3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                    $Url3 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000038&itemidx=2&sign=9ff47c89986a5df571095e1b3d16d200#wechat_redirect";
                    $item3 = sprintf($itemTpl, $Title3, $Discription3, $PicUrl3, $Url3);

                    $Title4 = "回复“帮助”查看帮助";
                    $Discription4 = "";
                    $PicUrl4 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/fanyetubiao.png";
                    $Url4 = "";
                    $item4 = sprintf($itemTpl, $Title4, $Discription4, $PicUrl4, $Url4);

                    $resultStr = $news_fore . $item1 . $item2 . $item3 . $item4 . $news_end;
                    $return = new Saestorage;
                    $return->write('hsdzzxy', 'text.txt', $resultStr);
                    echo $resultStr;
                    exit;
                }
            }
            else if ($textContent == "地图")  //地图
            {
                $mc->set($fromUsername . "_do", "ditu", 0, 600);
                $msgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请选择东西区：\n1.西区\n2.东区");
                echo $resultStr;
                exit;
            }
            else if ($textContent == "1") {
                if ($last_do == "ditu") {
                    $msgType = "news";
                    $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, 1);
                    $Title2 = "西区地图";
                    $Discription2 = "";
                    $PicUrl2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/dongqudamen.jpg";
                    $Url2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E7%BD%91%E9%A1%B5/xiququdituwangye.html";
                    $item2 = sprintf($itemTpl, $Title2, $Discription2, $PicUrl2, $Url2);
                    $resultStr = $news_fore . $item2 . $news_end;
                    echo $resultStr;
                    exit;
                }
            }
            else if ($textContent == "2") {
                if ($last_do == "ditu") {
                    $msgType = "news";
                    $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, 1);
                    $Title3 = "东区地图";
                    $Discription3 = "";
                    $PicUrl3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/dongqudamen.jpg";
                    $Url3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E7%BD%91%E9%A1%B5/dongqudituwangye.html";
                    $item3 = sprintf($itemTpl, $Title3, $Discription3, $PicUrl3, $Url3);
                    $resultStr = $news_fore . $item3 . $news_end;
                    echo $resultStr;
                    exit;
                }
            }
            else if (substr($textContent, 0, 9) == "公选课") {
                $entityName = trim(substr($textContent, 9, strlen($textContent)));
                if ($entityName == "") {
                    $msgType = "text";
                    $contentStr = "发送“公选课”加上课程名称，如“公选课合同法”";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                $gxk_value = array(15);       //定义公选课数组
                if ($entityName == "随机")    //随机公选课
                {
                    $gxk_rand = rand(1, 317);
                    $gxk_value[0] = $mysql->getLine("select *
           							   from gongxuanke
                                       where '$gxk_rand'=gxk_id");
                    $i = 0;
                    if ($gxk_value[0]["gxk_address"] == NULL) {
                        $gxk_value[0]["gxk_address"] = "教室未给出o>_<o";
                    }
                    while ($gxk_value[$i]["gxk_teacher"] == NULL) {
                        $temp = $gxk_value[$i]["gxk_id"] - 1;
                        $gxk_value[$i + 1] = $mysql->getLine("select *
						                     from gongxuanke
                                             where gxk_id=$temp");
                        $i = $i + 1;
                    }
                    $gxk_value[0]["gxk_teacher"] = $gxk_value[$i]["gxk_teacher"];
                    $i = 0;
                    while ($gxk_value[$i]["gxk_name"] == NULL) {
                        $temp = $gxk_value[$i]["gxk_id"] - 1;
                        $gxk_value[$i + 1] = $mysql->getLine("select *
		   			                     from gongxuanke
                                             where gxk_id=$temp");
                        $i = $i + 1;
                    }
                    $gxk_value[0]["gxk_name"] = $gxk_value[$i]["gxk_name"];
                    $msgType = "text";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $gxk_value[0]["gxk_name"] . "\n老师：" . $gxk_value[0]["gxk_teacher"] . "\n时间：" . $gxk_value[0]["gxk_time"] . "\n周次：" . $gxk_value[0]["gxk_zhouci"] . "周" . "\n教室：" . $gxk_value[0]["gxk_address"]);
                    echo $resultStr;
                    exit;
                }
                //查询数据库

                $gxk_value[0] = $mysql->getLine("select *
            						   from gongxuanke
                                       where gxk_name Like '%$entityName%'");
                //查无此课
                if (!$gxk_value[0]) {
                    $msgType = "text";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "o>_<o无此课程，请重新输入，如需帮助，请回复“帮助”。");
                    echo $resultStr;
                    exit;
                } //查询成功返回消息
                else {
                    if ($gxk_value[0]["gxk_teacher"] == NULL) {
                        $gxk_value[0]["gxk_teacher"] = "未给出";
                    }
                    do    //同课多教室
                    {
                        if ($gxk_value[$i]["gxk_address"] == NULL) {
                            $gxk_value[$i]["gxk_address"] = "教室未给出o>_<o";
                        }
                        $i = $i + 1;
                        $temp = $gxk_value[0]["gxk_id"] + $i;
                        $gxk_value[$i] = $mysql->getLine("select *
						                     from gongxuanke
                                             where gxk_id=$temp");
                    } while ($gxk_value[$i]["gxk_name"] == NULL);
                    $j = 1;
                    while ($j < $i) {
                        if ($gxk_value[$j]["gxk_teacher"] == NULL) {
                            $gxk_value[$j]["gxk_teacher"] = $gxk_value[$j - 1]["gxk_teacher"];

                        }
                        $j = $j + 1;
                    }
                    $j = 1;
                    $text_content = $gxk_value[0]["gxk_name"] . "\n--------\n1、" . $gxk_value[0]["gxk_teacher"] . " \n" . $gxk_value[0]["gxk_time"] . "\n第" . $gxk_value[0]["gxk_zhouci"] . "周" . "\n" . $gxk_value[0]["gxk_address"];
                    while ($j < $i) {
                        $text_content = $text_content . "\n--------\n" . ($j + 1) . "、" . $gxk_value[$j]["gxk_teacher"] . " \n" . $gxk_value[$j]["gxk_time"] . "\n第" . $gxk_value[0]["gxk_zhouci"] . "周" . "\n" . $gxk_value[$j]["gxk_address"];
                        $j = $j + 1;
                    }
                    $msgType = "text";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $text_content);
                    echo $resultStr;
                    exit;
                }
            } else if ($textContent == "校歌")   //校歌
            {
                $msgType = "music";
                $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, time(), $msgType, "校歌", "河南师范大学", "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E9%9F%B3%E4%B9%90/xiaogeyuanchang.mp3", "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E9%9F%B3%E4%B9%90/xiaogeyuanchang.mp3");
                echo $resultStr;
                exit;
            } // http://api2.sinaapp.com/search/music/?appkey=0020130430&appsecert=fa6095e1133d28ad&reqtype=music&keyword=%E6%9C%80%E7%82%AB%E6%B0%91%E6%97%8F%E9%A3%8E
            else if (substr($textContent, 0, 6) == "点歌") {
                $entityName = trim(substr($textContent, 6, strlen($textContent)));
                if ($entityName == "") {
                    $msgType = "text";
                    $contentStr = "发送“点歌”加上歌名，歌曲名前加" - "，如“点歌稻香-周杰伦”";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                    $return = new Saestorage;
                    $return->write('hsdzzxy', 'text.txt', $resultStr);
                    echo $resultStr;
                    exit;
                }

                $dstr = array(2);
                $dstr[0] = strtok($entityName, "-");
                if ($dstr[$i] !== false) {
                    $dstr[1] = strtok("-");
                    $apicallurl = "http://box.zhangmen.baidu.com/x?op=12&count=1&title=" . urlencode($dstr[0]) . "$$" . urlencode($dstr[1]) . "$$$$";
                } else {
                    $apicallurl = "http://box.zhangmen.baidu.com/x?op=12&count=1&title=" . urlencode($entityName) . "$$$$$$";
                }
                $postStr = file_get_contents($apicallurl);
                if ($postStr == NULL) {
                    $msgType = "text";
                    $contentStr = "无此歌曲，“点歌”加上歌名，歌曲名前加空格，如“点歌 稻香”";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);

                    echo $resultStr;
                    exit;
                }


                //解析数据
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

                $url = $postObj->url->encode;
                $_url = $postObj->url->decode;
                $durl = $postObj->durl->encode;
                $_durl = $postObj->durl->decode;

                $url_str = array(7);
                $url_str[0] = strtok($url, "/");

                $i = 0;
                while ($url_str[$i] !== false) {
                    $i = $i + 1;
                    $url_str[$i] = strtok("/");
                }

                $_url_str = array(2);
                $_url_str[0] = strtok($_url, "&");
                $musicUrl = $url_str[0] . "//" . $url_str[1] . "/" . $url_str[2] . "/" . $url_str[3] . "/" . $url_str[4] . "/" . $_url_str[0];
                $durl_str = array(7);
                $durl_str[0] = strtok($durl, "/");
                $i = 0;
                while ($durl_str[$i] !== false) {
                    $i = $i + 1;
                    $durl_str[$i] = strtok("/");
                }
                $_durl_str = array(2);
                $_durl_str[0] = strtok($_durl, "&");
                $QmusicUrl = $durl_str[0] . "//" . $durl_str[1] . "/" . $url_str[2] . "/" . $durl_str[3] . "/" . $durl_str[4] . "/" . $_durl_str[0];
                $msgType = "music";
                $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, time(), $msgType, $entityName, "河师大掌中校园", $musicUrl, $QmusicUrl);
                echo $resultStr;
                exit;
            } else {
                //$contentStr=getTulingResp($textContent);
                $contentStr = getXiaoiInfo($fromUsername, $textContent);

                $msgType = "text";

                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
                echo $resultStr;


                exit;

            }
        }
    } /**********************************************
     * 关键字
     **********************************************/
    else {
        echo "";
        exit;
    }
}
?>