<?php

namespace NFTCN\Util;


/**
 * matic : 0xA1371324179016dFb354De0DC87953F6e66F0706
 */
class SmartContractUtil
{
    private $url = "";

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function mint()
    {
        $requestUrl = $this->url . "/jsonrpc/mint";
        $result = curlGet($requestUrl);
        return $result;
    }

    public function baseinfo()
    {
        $requestUrl = $this->url . "/jsonrpc/baseinfo";
        $result = curlGet($requestUrl);
        return $result;
    }

    public function ownerOf($tokenId)
    {
        $requestUrl = $this->url . "/jsonrpc/ownerOf?tokenId=" . $tokenId;
        $result = curlPost($requestUrl, []);
        return $result;
    }

    public function burn($tokenId)
    {
        $requestUrl = $this->url . "/jsonrpc/burn?tokenId=" . $tokenId;
        $result = curlPost($requestUrl, []);
        return $result;
    }

    public function transfer($receive, $tokenId)
    {
        $requestUrl = $this->url . "/jsonrpc/transfer?tokenId=" . $tokenId . "&to=" . $receive;
        $result = curlPost($requestUrl, []);
        return $result;
    }

    public function totalSupply()
    {
        $requestUrl = $this->url . "/jsonrpc/totalSupply";
        $result = curlGet($requestUrl);
        return $result;
    }

    public function tokenURI($tokenId)
    {
        $requestUrl = $this->url . "/jsonrpc/tokenURI?tokenId=" . $tokenId;
        $result = curlPost($requestUrl, []);
        return $result;
    }

    public function getCurrentIndex()
    {
        $requestUrl = $this->url . "/jsonrpc/getCurrentIndex";
        $result = curlGet($requestUrl);
        return $result;
    }
}