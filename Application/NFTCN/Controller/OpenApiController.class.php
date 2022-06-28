<?php

namespace NFTCN\Controller;

use NFTCN\Model\MetadataModel;
use NFTCN\Model\XsdMetadataModel;
use NFTCN\Util\SmartContractUtil;

/**
 * 公共接口部分
 */
class OpenApiController extends CommonController
{
    private $jsonRpcUrl = "http://47.52.129.69:8088";

    function mint()
    {
        $image = I("image");
        $animation_url = I("animation_url", '');
        $external_url = I("external_url", '');
        $name = I("name", '');
        $description = I("description", '');

        //create metadata
        $MetadataModel = new MetadataModel();
        $XsdMetadataModel = new XsdMetadataModel();
        $SmartContractUtil = new SmartContractUtil($this->jsonRpcUrl);

        $metadata = $MetadataModel->create($image, $animation_url, $external_url, $name, $description);
        $result = $SmartContractUtil->getCurrentIndex();
        $result = json_decode($result, true);
        if ($result['state'] == false) {
            $this->jerror("json_rpc connect error");
        }
        $tokenId = $result['data'];
        $ret = $XsdMetadataModel->createMetadata($tokenId, $name, $description, $image, $animation_url, $external_url);
        if ($ret) {
            $resultMint = $SmartContractUtil->mint();
            $resultMint = json_decode($resultMint, true);
            if ($resultMint['state'] == true) {
                $metadata['token_id'] = $tokenId;
                $return = [
                    'txid' => $resultMint['data'],
                    'metadata' => $metadata
                ];
                $this->jsuccess($return);
            } else {
                $this->jerror($resultMint['message']);
            }
        }
    }

    function baseinfo()
    {
        $SmartContractUtil = new SmartContractUtil($this->jsonRpcUrl);
        $result = $SmartContractUtil->baseinfo();
        $result = json_decode($result, true);
        if ($result['state'] == false) {
            $this->jerror($result['message']);
        } else {
            $this->jsuccess($result['data']);
        }
    }

    function queryNFT()
    {
        $tokenId = I("tokenId");
        $XsdMetadataModel = new XsdMetadataModel();
        $SmartContractUtil = new SmartContractUtil($this->jsonRpcUrl);
        $MetadataModel = new MetadataModel();

        $xsdMetadata = $XsdMetadataModel->where(['token_id' => $tokenId])->find();
        $metadata = $MetadataModel->create($xsdMetadata['image'], $xsdMetadata['image'], "", $xsdMetadata['name'], $xsdMetadata['description']);
        $metadata['token_id'] = $tokenId;
        $result = $SmartContractUtil->baseinfo();
        $result = json_decode($result, true);
        $metadata['contract'] = $result['data']['contract'];
        $metadata['opensea_url'] = "https://opensea.io/assets/matic/{$metadata['contract']}/{$tokenId}";
        $result = $SmartContractUtil->ownerOf($tokenId);
        $result = json_decode($result, true);

        $owner = $result['data'];
        $return = [
            'owner' => $owner,
            'metadata' => $metadata
        ];
        $this->jsuccess($return);
    }

    function transfer()
    {
        $tokenId = I("tokenId");
        $to = I("to");
        $SmartContractUtil = new SmartContractUtil($this->jsonRpcUrl);
        $result = $SmartContractUtil->transfer($to, $tokenId);
        $this->processJsonrpcResult($result);
    }

    function burn()
    {
        $tokenId = I("tokenId");
        $SmartContractUtil = new SmartContractUtil($this->jsonRpcUrl);
        $result = $SmartContractUtil->burn($tokenId);
        $this->processJsonrpcResult($result);
    }

    private function processJsonrpcResult($result)
    {
        $result = json_decode($result, true);
        if ($result['state']) {
            $this->jsuccess($result['data']);
        } else {
            $this->jerror($result['message']);
        }
    }

    function metadata($tokenId)
    {
        $XsdMetadataModel = new XsdMetadataModel();
        $MetadataModel = new MetadataModel();

        $xsdMetadata = $XsdMetadataModel->where(['token_id' => $tokenId])->find();
        $metadata = $MetadataModel->create($xsdMetadata['image'], $xsdMetadata['image'], "", $xsdMetadata['name'], $xsdMetadata['description']);
        header('Content-Type:application/json; charset=utf-8');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:*');
        header("Access-Control-Request-Headers:*");
        exit(json_encode($metadata));
    }
}