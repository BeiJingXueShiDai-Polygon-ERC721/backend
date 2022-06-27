<?php

namespace NFTCN\Util;

/**
 * API Key: 32aa3198ffc9d4789f67
 * API Secret: 8039b5b5fc3202df5cfcb48dc8378b002c9d029fb3423514e0b8aa63d4169aa8
 * JWT: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySW5mb3JtYXRpb24iOnsiaWQiOiIwODBmYjUxMC0wODk5LTRiOTItYTA4MS03MzE4ZTk4MTE2NTkiLCJlbWFpbCI6ImJpdG1hbi5ldGhAb3V0bG9vay5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwicGluX3BvbGljeSI6eyJyZWdpb25zIjpbeyJpZCI6IkZSQTEiLCJkZXNpcmVkUmVwbGljYXRpb25Db3VudCI6MX0seyJpZCI6Ik5ZQzEiLCJkZXNpcmVkUmVwbGljYXRpb25Db3VudCI6MX1dLCJ2ZXJzaW9uIjoxfSwibWZhX2VuYWJsZWQiOmZhbHNlLCJzdGF0dXMiOiJBQ1RJVkUifSwiYXV0aGVudGljYXRpb25UeXBlIjoic2NvcGVkS2V5Iiwic2NvcGVkS2V5S2V5IjoiMzJhYTMxOThmZmM5ZDQ3ODlmNjciLCJzY29wZWRLZXlTZWNyZXQiOiI4MDM5YjViNWZjMzIwMmRmNWNmY2I0OGRjODM3OGIwMDJjOWQwMjlmYjM0MjM1MTRlMGI4YWE2M2Q0MTY5YWE4IiwiaWF0IjoxNjU2MzAzMzYxfQ.6SphnDE6B8nfPg_eBhPgI83hevuhvHuB9lROnab5MDI
 */
class PinataIPFS
{
    public $baseUrl = "https://api.pinata.cloud";
    public $jwt = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySW5mb3JtYXRpb24iOnsiaWQiOiIwODBmYjUxMC0wODk5LTRiOTItYTA4MS03MzE4ZTk4MTE2NTkiLCJlbWFpbCI6ImJpdG1hbi5ldGhAb3V0bG9vay5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwicGluX3BvbGljeSI6eyJyZWdpb25zIjpbeyJpZCI6IkZSQTEiLCJkZXNpcmVkUmVwbGljYXRpb25Db3VudCI6MX0seyJpZCI6Ik5ZQzEiLCJkZXNpcmVkUmVwbGljYXRpb25Db3VudCI6MX1dLCJ2ZXJzaW9uIjoxfSwibWZhX2VuYWJsZWQiOmZhbHNlLCJzdGF0dXMiOiJBQ1RJVkUifSwiYXV0aGVudGljYXRpb25UeXBlIjoic2NvcGVkS2V5Iiwic2NvcGVkS2V5S2V5IjoiMzJhYTMxOThmZmM5ZDQ3ODlmNjciLCJzY29wZWRLZXlTZWNyZXQiOiI4MDM5YjViNWZjMzIwMmRmNWNmY2I0OGRjODM3OGIwMDJjOWQwMjlmYjM0MjM1MTRlMGI4YWE2M2Q0MTY5YWE4IiwiaWF0IjoxNjU2MzAzMzYxfQ.6SphnDE6B8nfPg_eBhPgI83hevuhvHuB9lROnab5MDI";
    public $key = "aa3198ffc9d4789f67";
    public $secret = "8039b5b5fc3202df5cfcb48dc8378b002c9d029fb3423514e0b8aa63d4169aa8";

    public function testAuthentication()
    {
        $url = $this->baseUrl . "/data/testAuthentication";
        return $this->curlGet($url);
    }

    public function pinFileToIPFS($file, $name)
    {
        $fileFullPath = $file['file']['tmp_name'] . "/" . $file['file']['name'];
        $url = $this->baseUrl . "/pinning/pinFileToIPFS";
        $post = [
            'file' => "@" . $fileFullPath,
            'pinataOptions' => '{\"cidVersion\": 1}',
            'pinataMetadata' => "{\"name\": \"{$name}\", \"keyvalues\": {\"company\": \"Pinata\"}}"
        ];
        var_dump($file);
        var_dump($fileFullPath);
        var_dump($post['file']);
        var_dump($post);

        $result = $this->curlPost($url, $post);
        var_dump($result);
    }

    /*

     █╗     ██╗██████╗      ██████╗ ███████╗     ██████╗██╗   ██╗██████╗ ██╗
    ██║     ██║██╔══██╗    ██╔═══██╗██╔════╝    ██╔════╝██║   ██║██╔══██╗██║
    ██║     ██║██████╔╝    ██║   ██║█████╗      ██║     ██║   ██║██████╔╝██║
    ██║     ██║██╔══██╗    ██║   ██║██╔══╝      ██║     ██║   ██║██╔══██╗██║
    ███████╗██║██████╔╝    ╚██████╔╝██║         ╚██████╗╚██████╔╝██║  ██║███████╗
    ╚══════╝╚═╝╚═════╝      ╚═════╝ ╚═╝          ╚═════╝ ╚═════╝ ╚═╝  ╚═╝╚══════╝

    */

    private function curlGet($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Authorization: Bearer {$this->jwt}",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

    private function curlPost($url, $data = '', $agent = '')
    {
        $headers = array(
            "Accept: multipart/form-data",
            "Authorization: Bearer {$this->jwt}",
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $agent);
        $file_contents = curl_exec($curl);
        curl_close($curl);
        if ($file_contents === false) {
            throw new \Exception('CURL错误，错误代码：' . curl_errno($curl));
        }
        return $file_contents;
    }
}