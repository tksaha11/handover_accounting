<?php
    namespace App\Http\Traits\Nagad;

    trait Helper{
        function generateRandomString($length = 40)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        function EncryptDataWithPublicKey($data)
        {
            $pgPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiCWvxDZZesS1g1lQfilVt8l3X5aMbXg5WOCYdG7q5C+Qevw0upm3tyYiKIwzXbqexnPNTHwRU7Ul7t8jP6nNVS/jLm35WFy6G9qRyXqMc1dHlwjpYwRNovLc12iTn1C5lCqIfiT+B/O/py1eIwNXgqQf39GDMJ3SesonowWioMJNXm3o80wscLMwjeezYGsyHcrnyYI2LnwfIMTSVN4T92Yy77SmE8xPydcdkgUaFxhK16qCGXMV3mF/VFx67LpZm8Sw3v135hxYX8wG1tCBKlL4psJF4+9vSy4W+8R5ieeqhrvRH+2MKLiKbDnewzKonFLbn2aKNrJefXYY7klaawIDAQAB";
            $public_key = "-----BEGIN PUBLIC KEY-----\n" . $pgPublicKey . "\n-----END PUBLIC KEY-----";

            $key_resource = openssl_get_publickey($public_key);
            openssl_public_encrypt($data, $cryptText, $key_resource);
            return base64_encode($cryptText);
        }



        function SignatureGenerate($data)
        {
            $merchantPrivateKey = "MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDLXB4xnUj3zeQsrcCA9vxP+91hU0TstH3Cu025/b1pVUSRJJt/cBZum3a2zhzjMGf+zalH5lUu4gAiFmrbnQ15wbQSElpvnME18gYn80Qja4PKPLYtpEOia5kUxADu5VjRr2108kAIhuDB2MdZKCZ7LXZ3KwnGDYBynwbNE8A66S8kJyEFxgaQN3lBGO6K2/dxF6E2Eqig1FSdwQg2pw2a7fVU1rOpaepwPLspZzPzjp59FiAViaBsThH/3FUZ3TcwRWai1mSCJzkSwbBK2l+/ikWhqwnt9hvyeiZTvpnTKYoV2gGmynIiivFP8z5FrE3airS1z5reUj2CzsYGdaNlAgMBAAECggEANR3kjRUGICPZO4pOw+C/Wqzw0CEN2b3zM0/1J2WNedvZwweKziia010sDuebSAQ2xak2VB9nlI1Xd4/fbWmCQZFE1YuRr6GEHfEPhpPV8mJ80/AzrYxAVkZAf9oKXFvvbSWjM26rJw8D2d4jg7gnBPmE/e9x6BdSu52qCxrjlP8n+Y4gtGiGPteyPBoCpBDdArqMX6XvMpIgWeIy6Xm8pwt0E6uMF89+X98M6jsIyj3JZSvo5AxcXuqshizpIvF2zFY3W1S2n10BJPDcBkTM6qe5XnsfyD6iWslgDI+/jYfiHI3hpmHunbo8q41gs76Qvl/nfSSozFAf5CzsaEcYgQKBgQDx2JpbJnJIir5iRNxzp5VqQQMvTwW54Z1eaZFlvXQeDzNL4c3lPMORLj/zrOkRdMR6bTVvZhXAgW6dUFHe5cV1UTk7F396As2oYiYp1NkR/v8zWNR+iFNP8leub8xq4QBrNh2aA1PpQDqJbFqvifl6PdVliM5GPI4Tz+094QIm9QKBgQDXQueEH0GjDU9wXAjQdZKvtcjJNP3QvVcpOvABDchGTZq7K1DVUDYnQfdS6GEEW1Zso6xvuK0WGGkFOmvvEncGTvSqVvdLWFKl/JQ2dvMrH9thJ3sisQDD51A32p38I7rgp5CktfvMhAZfXiqiZbAv7ixpwApsk0aoRgazhx1ksQKBgQDVW4rpaSSffM9y8F8wJSM65voBTYy2rSThOu8Lu7TqI+zUP/QeDZpWxV+kAOJpBQOlIh1nFr+P4mAMpuRjaX/m/O4phJRwtnJq35PdiaqrJrRLv01QB8LAIANcn8LOc4ukCczZp5/qgkBiJlZm0KloP464kZWw/xE0x1X8Jjp41QKBgQCpJi+aiJ0hLRJhLlDWzayoWeYfBX71CfN1uJRjn5ric5TEwvLPzCnhi1p3UZb6v3MYBz02xR1toVzU+OVbhVz2HhDv0UqdcBfxypoEek/2cSAIJegCiKgbSKamXSmLud/dLI7ifwYP3SbMxcgmuFVMNJG9v2PxkYESNYSKif+04QKBgQCi+vA5j3S5bl/9YQq4ebAp79erEbMVjv1N8AjxjodeVUeSYSD/PWQ9BjkEfZVDCMWE3TAZRgK9Eop+xHz7edRd7V1t9hSHWQdEJq6+J/JWQdaAgRxCrhJClOu4ZPTr19ysv+tTG6QVVeT6EARMBwbJrxpgoMcXhsd6SnMGplCYeA==";
            $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
        
            openssl_sign($data, $signature, $private_key, OPENSSL_ALGO_SHA256);
            return base64_encode($signature);
        }



        function HttpPostMethod($PostURL, $PostData)
        {
            $url = curl_init($PostURL);
            $postToken = json_encode($PostData);
            $header = array(
                'Content-Type:application/json',
                'X-KM-Api-Version:v-0.2.0',
                'X-KM-IP-V4:' . $this->get_client_ip(),
                'X-KM-Client-Type:PC_WEB'
            );
            
            curl_setopt($url, CURLOPT_HTTPHEADER, $header);
            curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
            curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false); 
            // curl_setopt($url, CURLOPT_HEADER, 1); 
            
            $resultData = curl_exec($url);
            $ResultArray = json_decode($resultData, true);
            $header_size = curl_getinfo($url, CURLINFO_HEADER_SIZE);
            curl_close($url);
                $headers = substr($resultData, 0, $header_size);
                $body = substr($resultData, $header_size);
                print_r($body);
                print_r($headers);
            return $ResultArray;

        }

        function get_client_ip()
        {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if (isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }

        function DecryptDataWithPrivateKey($cryptText)
        {
            $merchantPrivateKey = "MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDLXB4xnUj3zeQsrcCA9vxP+91hU0TstH3Cu025/b1pVUSRJJt/cBZum3a2zhzjMGf+zalH5lUu4gAiFmrbnQ15wbQSElpvnME18gYn80Qja4PKPLYtpEOia5kUxADu5VjRr2108kAIhuDB2MdZKCZ7LXZ3KwnGDYBynwbNE8A66S8kJyEFxgaQN3lBGO6K2/dxF6E2Eqig1FSdwQg2pw2a7fVU1rOpaepwPLspZzPzjp59FiAViaBsThH/3FUZ3TcwRWai1mSCJzkSwbBK2l+/ikWhqwnt9hvyeiZTvpnTKYoV2gGmynIiivFP8z5FrE3airS1z5reUj2CzsYGdaNlAgMBAAECggEANR3kjRUGICPZO4pOw+C/Wqzw0CEN2b3zM0/1J2WNedvZwweKziia010sDuebSAQ2xak2VB9nlI1Xd4/fbWmCQZFE1YuRr6GEHfEPhpPV8mJ80/AzrYxAVkZAf9oKXFvvbSWjM26rJw8D2d4jg7gnBPmE/e9x6BdSu52qCxrjlP8n+Y4gtGiGPteyPBoCpBDdArqMX6XvMpIgWeIy6Xm8pwt0E6uMF89+X98M6jsIyj3JZSvo5AxcXuqshizpIvF2zFY3W1S2n10BJPDcBkTM6qe5XnsfyD6iWslgDI+/jYfiHI3hpmHunbo8q41gs76Qvl/nfSSozFAf5CzsaEcYgQKBgQDx2JpbJnJIir5iRNxzp5VqQQMvTwW54Z1eaZFlvXQeDzNL4c3lPMORLj/zrOkRdMR6bTVvZhXAgW6dUFHe5cV1UTk7F396As2oYiYp1NkR/v8zWNR+iFNP8leub8xq4QBrNh2aA1PpQDqJbFqvifl6PdVliM5GPI4Tz+094QIm9QKBgQDXQueEH0GjDU9wXAjQdZKvtcjJNP3QvVcpOvABDchGTZq7K1DVUDYnQfdS6GEEW1Zso6xvuK0WGGkFOmvvEncGTvSqVvdLWFKl/JQ2dvMrH9thJ3sisQDD51A32p38I7rgp5CktfvMhAZfXiqiZbAv7ixpwApsk0aoRgazhx1ksQKBgQDVW4rpaSSffM9y8F8wJSM65voBTYy2rSThOu8Lu7TqI+zUP/QeDZpWxV+kAOJpBQOlIh1nFr+P4mAMpuRjaX/m/O4phJRwtnJq35PdiaqrJrRLv01QB8LAIANcn8LOc4ukCczZp5/qgkBiJlZm0KloP464kZWw/xE0x1X8Jjp41QKBgQCpJi+aiJ0hLRJhLlDWzayoWeYfBX71CfN1uJRjn5ric5TEwvLPzCnhi1p3UZb6v3MYBz02xR1toVzU+OVbhVz2HhDv0UqdcBfxypoEek/2cSAIJegCiKgbSKamXSmLud/dLI7ifwYP3SbMxcgmuFVMNJG9v2PxkYESNYSKif+04QKBgQCi+vA5j3S5bl/9YQq4ebAp79erEbMVjv1N8AjxjodeVUeSYSD/PWQ9BjkEfZVDCMWE3TAZRgK9Eop+xHz7edRd7V1t9hSHWQdEJq6+J/JWQdaAgRxCrhJClOu4ZPTr19ysv+tTG6QVVeT6EARMBwbJrxpgoMcXhsd6SnMGplCYeA==";
            $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
            openssl_private_decrypt(base64_decode($cryptText), $plain_text, $private_key);
            return $plain_text;
        }
    }