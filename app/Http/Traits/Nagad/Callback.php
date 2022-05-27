<?php
    namespace App\Http\Traits\Nagad;

    /**
     * *****************************************************************
     * Copyright 2019.
     * All Rights Reserved to
     * Nagad
     * Redistribution or Using any part of source code or binary
     * can not be done without permission of Nagad
     * *****************************************************************
     *
     * @author - Md Nazmul Hasan Nazim
     * @email - nazmul.nazim@nagad.com.bd
     * @date: 03/03/2020
     * @time: 12:55 PM
     * ****************************************************************
     */

    trait Callback{

        private function HttpGet($url)
        {
            $ch = curl_init();
            $timeout = 10;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/0 (Windows; U; Windows NT 0; zh-CN; rv:3)");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $file_contents = curl_exec($ch);
            echo curl_error($ch);
            curl_close($ch);
            return $file_contents;
        }
        
    }
    


