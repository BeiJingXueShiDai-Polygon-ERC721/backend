<?php

namespace Admin\Controller;

use NFTCN\Util\PinataIPFS;

/**
 * 公共接口部分
 */
class OpenApiController extends CommonController
{
    /**
     * 上传图片
     */
    function uploadImage()
    {

    }

    function testAuthentication()
    {
        $PintaIPFS = new PinataIPFS();
        $result = $PintaIPFS->testAuthentication();
        $this->jsuccess($result);
    }

    function mint()
    {
        //create metadata
        //request mint api
        //return success
    }
}