<?php

namespace NFTCN\Model;

use Think\Model;

class XsdMetadataModel extends Model
{
    public function createMetadata($token_id, $name, $description, $image, $animation_url = '', $external_url = '')
    {
        $exist = $this->where(['token_id' => $token_id])->find();
        if ($exist) {
            $data = [
                'name' => $name,
                'description' => $description,
                'image' => $image,
                'animation_url' => $animation_url,
                'external_url' => $external_url,
                'create_time' => time(),
            ];
            $this->where(['token_id' => $token_id])->save($data);
            $ret = true;
        } else {
            $data = [
                'name' => $name,
                'description' => $description,
                'image' => $image,
                'animation_url' => $animation_url,
                'external_url' => $external_url,
                'create_time' => time(),
                'token_id' => $token_id
            ];
            $ret = $this->add($data);
        }
        return $ret;
    }
}