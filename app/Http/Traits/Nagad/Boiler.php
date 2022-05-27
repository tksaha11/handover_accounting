<?php
    namespace App\Http\Traits\Nagad;

    trait Boiler{
        public function SensitiveData($MerchantID,$DateTime,$OrderId,$random)
        {
            # code...
            $SensitiveData = array(
                'merchantId' => $MerchantID,
                'datetime' => $DateTime,
                'orderId' => $OrderId,
                'challenge' => $random
            );

            return $SensitiveData;
        }

        public function PostData($MerchantNumber,$DateTime,$SensitiveData)
        {
            # code...
            $PostData = array(
                'accountNumber' => $MerchantNumber, 
                'dateTime' => $DateTime,
                'sensitiveData' => $this->EncryptDataWithPublicKey(json_encode($SensitiveData)),
                'signature' => $this->SignatureGenerate(json_encode($SensitiveData))
            );

            return $PostData;
        }

        public function SensitiveDataOrder($MerchantID,$OrderId,$amount,$randomServer)
        {
            # code...
            $SensitiveDataOrder = array(
                'merchantId' => $MerchantID,
                'orderId' => $OrderId,
                'currencyCode' => '050',
                'amount' => $amount,
                'challenge' => $randomServer
            );

            return $SensitiveDataOrder;
        }

        public function MerchantAdditionalInfo($logo)
        {
            # code...
            // $data='{
            //     "serviceLogoURL": "'.$logo.'", 
            //     "additionalFieldNameEN": "Color", 
            //     "additionalFieldNameBN": "রং",
            //     "additionalFieldValue": "White"
            // }';
            $data='{
                "serviceLogoURL": "'.$logo.'"
            }';

            return $data;
        }

        public function PostDataOrder($SensitiveDataOrder,$merchantCallbackURL,$merchantAdditionalInfo)
        {
            # code...
            $PostDataOrder = array(
                'sensitiveData' => $this->EncryptDataWithPublicKey(json_encode($SensitiveDataOrder)),
                'signature' => $this->SignatureGenerate(json_encode($SensitiveDataOrder)),
                'merchantCallbackURL' => $merchantCallbackURL,
                'additionalMerchantInfo' => json_decode($merchantAdditionalInfo)
            );

            return $PostDataOrder;
        }
    }