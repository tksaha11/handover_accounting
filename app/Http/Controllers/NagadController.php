<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Nagad\Helper;
use App\Http\Traits\Nagad\Callback;
use App\Http\Traits\Nagad\Boiler;

class NagadController extends Controller
{
    //
    use Helper;
    use Callback;
    use Boiler;

    public function checkout($redirectUrl,$sensitiveData){

        $decodeArrayData=$this->decodeSensitiveData($sensitiveData);
        
        
        $MerchantID = "688101543025045";
        $DateTime = Date('YmdHis');
        $amount = $decodeArrayData["ammount"];
        $OrderId = $decodeArrayData["OrderId"];
        $random = $this->generateRandomString();  
        $MerchantNumber='01810154302';//Replace with Merchant Number
        $LogoLink='https://store.ablamardokan.com/public/assets/images/logo/logo-for-nagad.png';//Replace With Logo Link
        
        
        // $PostURL = "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs/check-out/initialize/" . $MerchantID . "/" . $OrderId;
        $PostURL = "https://api.mynagad.com/api/dfs/check-out/initialize/" . $MerchantID . "/" . $OrderId;

        $_SESSION['orderId'] = $OrderId;
        $merchantCallbackURL = env('store_seller_url')."/nagad/callback/".$redirectUrl;

        $SensitiveData = $this->SensitiveData($MerchantID,$DateTime,$OrderId,$random);

        $PostData = $this->PostData($MerchantNumber,$DateTime,$SensitiveData);

        $Result_Data = $this->HttpPostMethod($PostURL, $PostData);


        if (isset($Result_Data['sensitiveData']) && isset($Result_Data['signature'])) {
            if ($Result_Data['sensitiveData'] != "" && $Result_Data['signature'] != "") {
        
                $PlainResponse = json_decode($this->DecryptDataWithPrivateKey($Result_Data['sensitiveData']), true);
        
        
                if (isset($PlainResponse['paymentReferenceId']) && isset($PlainResponse['challenge'])) {
        
        
                    $paymentReferenceId = $PlainResponse['paymentReferenceId'];
        
        
                    $randomServer = $PlainResponse['challenge'];
        
                    $SensitiveDataOrder = $this->SensitiveDataOrder($MerchantID,$OrderId,$amount,$randomServer);
        
                    $merchantAdditionalInfo = $this->MerchantAdditionalInfo($LogoLink);
        
                    $PostDataOrder = $this->PostDataOrder($SensitiveDataOrder,$merchantCallbackURL,$merchantAdditionalInfo);
        

                    // $OrderSubmitUrl = "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs/check-out/complete/" . $paymentReferenceId;
                    $OrderSubmitUrl = "https://api.mynagad.com/api/dfs/check-out/complete/" . $paymentReferenceId;

                    $Result_Data_Order = $this->HttpPostMethod($OrderSubmitUrl, $PostDataOrder);
                        if ($Result_Data_Order['status'] == "Success") {
                            $url = json_encode($Result_Data_Order['callBackUrl']);   
                            echo "<script>window.open($url, '_self')</script>";  
                                    
                        }
                        else {
                            echo json_encode($Result_Data_Order);
                             
                        }
                } else {
                    echo json_encode($PlainResponse);
                        
                }
            }
        }
    }

    public function callback($redirectUrl){

        $redirectUrl=base64_decode($redirectUrl);

        $Query_String  = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1] );
        $payment_ref_id = substr($Query_String[2], 15); 
        // $url = "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs/verify/payment/".$payment_ref_id;
        $url = "https://api.mynagad.com/api/dfs/verify/payment/".$payment_ref_id;
        $json = $this->HttpGet($url);
        $arr = json_decode($json, true);


        // array:14 [▼
        //     "merchantId" => "683002007104225"
        //     "orderId" => "AD2201241005"
        //     "paymentRefId" => "MDEyNjEyMTYzODI5MC42ODMwMDIwMDcxMDQyMjUuQUQyMjAxMjQxMDA1LjNhYzhjNGY0MjkxZjQwM2FjNzZl"
        //     "amount" => "10"
        //     "clientMobileNo" => "015****3442"
        //     "merchantMobileNo" => "01300200710"
        //     "orderDateTime" => "2022-01-26 12:16:37.0"
        //     "issuerPaymentDateTime" => "2022-01-26 12:17:24.0"
        //     "issuerPaymentRefNo" => "0000ZEJU"
        //     "additionalMerchantInfo" => "{"serviceLogoURL":"https://ablamardokan.com/assets/logo/logo.png","additionalFieldNameEN":"Color","additionalFieldNameBN":"রং","additionalFieldValue":"White"}"
        //     "status" => "Success"
        //     "statusCode" => "000"
        //     "cancelIssuerDateTime" => null
        //     "cancelIssuerRefNo" => null
        // ]
        // echo json_encode($arr);  

        $reduiredData=array(
            "orderId"=>$arr['orderId'],
            "paymentRefId"=>$arr['paymentRefId'],
            "amount"=>$arr['amount'],
            "clientMobileNo"=>$arr['clientMobileNo'],
            "issuerPaymentDateTime"=>$arr['issuerPaymentDateTime'],
            "status"=>$arr['status']
        );
        $data=json_encode($reduiredData);  

        $data=base64_encode($data);
        $url=$redirectUrl.$data;
        return redirect()->to($url);
    }

    function decodeSensitiveData($sensitiveData){
        $encryption=base64_decode($sensitiveData);

        $ciphering="AES-128-CTR";
        $option=0;
        $encryption_iv="6706091387437026";
        $encryption_key='MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCJakyLqojWTDAVUdNJLvuXhROV+LXymqnukBrmiWwTYnJYm9r5cKHj1hYQRhU5eiy6NmFVJqJtwpxyyDSCWSoSmIQMoO2KjYyB5cDajRF45v1GmSeyiIn0hl55qM8ohJGjXQVPfXiqEB5c5REJ8Toy83gzGE3ApmLipoegnwMkewsTNDbe5xZdxN1qfKiRiCL720FtQfIwPDp9ZqbG2OQbdyZUB8I08irKJ0x/psM4SjXasglHBK5G1DX7BmwcB/PRbC0cHYy3pXDmLI8pZl1NehLzbav0Y4fP4MdnpQnfzZJdpaGVE0oI15lq+KZ0tbllNcS+/4MSwW+afvOw9bazAgMBAAECggEAIkenUsw3GKam9BqWh9I1p0Xmbeo+kYftznqai1pK4McVWW9//+wOJsU4edTR5KXK1KVOQKzDpnf/CU9SchYGPd9YScI3n/HR1HHZW2wHqM6O7na0hYA0UhDXLqhjDWuM3WEOOxdE67/bozbtujo4V4+PM8fjVaTsVDhQ60vfv9CnJJ7dLnhqcoovidOwZTHwG+pQtAwbX0ICgKSrc0elv8ZtfwlEvgIrtSiLAO1/CAf+uReUXyBCZhS4Xl7LroKZGiZ80/JE5mc67V/yImVKHBe0aZwgDHgtHh63/50/cAyuUfKyreAH0VLEwy54UCGramPQqYlIReMEbi6U4GC5AQKBgQDfDnHCH1rBvBWfkxPivl/yNKmENBkVikGWBwHNA3wVQ+xZ1Oqmjw3zuHY0xOH0GtK8l3Jy5dRL4DYlwB1qgd/Cxh0mmOv7/C3SviRk7W6FKqdpJLyaE/bqI9AmRCZBpX2PMje6Mm8QHp6+1QpPnN/SenOvoQg/WWYM1DNXUJsfMwKBgQCdtddE7A5IBvgZX2o9vTLZY/3KVuHgJm9dQNbfvtXw+IQfwssPqjrvoU6hPBWHbCZl6FCl2tRh/QfYR/N7H2PvRFfbbeWHw9+xwFP1pdgMug4cTAt4rkRJRLjEnZCNvSMVHrri+fAgpv296nOhwmY/qw5Smi9rMkRY6BoNCiEKgQKBgAaRnFQFLF0MNu7OHAXPaW/ukRdtmVeDDM9oQWtSMPNHXsx+crKY/+YvhnujWKwhphcbtqkfj5L0dWPDNpqOXJKV1wHt+vUexhKwus2mGF0flnKIPG2lLN5UU6rs0tuYDgyLhAyds5ub6zzfdUBG9Gh0ZrfDXETRUyoJjcGChC71AoGAfmSciL0SWQFU1qjUcXRvCzCK1h25WrYS7E6pppm/xia1ZOrtaLmKEEBbzvZjXqv7PhLoh3OQYJO0NM69QMCQi9JfAxnZKWx+m2tDHozyUIjQBDehve8UBRBRcCnDDwU015lQN9YNb23Fz+3VDB/LaF1D1kmBlUys3//r2OV0Q4ECgYBnpo6ZFmrHvV9IMIGjP7XIlVa1uiMCt41FVyINB9SJnamGGauW/pyENvEVh+ueuthSg37e/l0Xu0nm/XGqyKCqkAfBbL2Uj/j5FyDFrpF27PkANDo99CdqL5A4NQzZ69QRlCQ4wnNCq6GsYy2WEJyU2D+K8EBSQcwLsrI7QL7fvQ==';

        $decription=openssl_decrypt($encryption,$ciphering,$encryption_key,$option,$encryption_iv);

        // echo base64_decode(json_decode($decription,true));
        $decodeStringData=base64_decode($decription);
        
        $decodeArrayData=json_decode($decodeStringData,true);

        return $decodeArrayData;
    }
}
