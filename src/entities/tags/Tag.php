<?php

namespace Oportunista\entities\tags;

class Tag implements \JsonSerializable
{
    private $id;
    private $name;

    public function __construct(array $tag)
    {
        $this->id = $tag['id'] ?? null;
        $this->name = $tag['name'] ?? null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}