<?php

namespace Altayer\CustomCatalog\Api;

use Altayer\CustomCatalog\Api\SyncDataInterface;

interface SubscriberInterface
{
    /**
     * @return void
     */
    public function proceed(SyncDataInterface $data);
}