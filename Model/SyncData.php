<?php

namespace Altayer\CustomCatalog\Model;

use Altayer\CustomCatalog\Api\SyncDataInterface;

class SyncData implements SyncDataInterface
{
    /**
     * @var string
     */
    protected $data;

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        return $this->data = $data;
    }
}