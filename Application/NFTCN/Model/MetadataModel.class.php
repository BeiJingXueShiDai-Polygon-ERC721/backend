<?php

namespace GenesisShirt\Model;

class MetadataModel
{
    function create($image, $animation_url, $external_url, $name, $description)
    {
        return [
            'image' => $image,
            'animation_url' => $animation_url,
            'external_url' => $external_url,
            'name' => $name,
            'description' => $description
        ];
    }
}