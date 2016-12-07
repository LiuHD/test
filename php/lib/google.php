<?php
function tranlateByGoogle($sourceText, $target, $source = 'en'){
        $url = "https://www.googleapis.com/language/translate/v2?key=AIzaSyCqLR9a_VLcvTHiJkrieOekPRuP9pwnQ4U";
        if($source){
            $url .= '&source=' . $source;
        }
        $stard_length = 1000;
        $tran_real_arr = array();
        if(strlen(urlencode($sourceText)) > $stard_length){
            $tran_arr = preg_split('/(\s)/i', $sourceText);
            $tran_temp = '';
            for ($i = 0; $i < count($tran_arr); $i++) {
                if (strlen(urlencode($tran_temp . $tran_arr[$i])) > $stard_length) {
                    $tran_real_arr[] = str_replace('\r\n', '<br>', $tran_temp) . " ";
                    $tran_temp = $tran_arr[$i];
                } else {
                    $tran_temp .= $tran_arr[$i] . " ";
                }
                if ($i == count($tran_arr) - 1) {
                    $tran_real_arr[] = str_replace('\r\n', '<br>', $tran_temp);
                    break;
                }
            }
        }else{
            $tran_real_arr[] = $sourceText;
        }

        $return_data = '';
        foreach($tran_real_arr as $t){
            $url_temp = $url . "&target=". $target ."&q=" . urlencode($t);

            //curl_init & curl_setopt
            $ch = curl_init($url_temp);
            curl_setopt($ch, CURLOPT_USERPWD, null.":".null);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, "__monitor__");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

            //curl_exec
            $result = curl_exec($ch);
            $result_parts = explode("\n\r", $result);
            $content = "";
            if(count($result_parts) > 1){
                $response_headers = $result_parts[0];
                for($i = 1; $i < count($result_parts); $i++){
                    $content .= $result_parts[$i];
                }
            }else{
                $content = $result_parts[0];
            }
            $info = curl_getinfo($ch);
            if($info['http_code'] == 401){
                $content = file_get_contents($url_temp);
            }

            $data = trim($content);
            $tran = json_decode($data, true);
            $return_data .= $tran['data']['translations'][0]['translatedText'];
            sleep(1);
        }
        return $return_data;
    }