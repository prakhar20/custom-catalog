<?php
namespace Altayer\CustomCatalog\Api;

/**
 * Interface SyncDataInterface
 *
 * @api
 */
interface SyncDataInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function setData($data);
    /**
     * @return string
     */
    public function getData();
}
