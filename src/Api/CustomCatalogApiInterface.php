<?php
namespace Altayer\CustomCatalog\Api;
 


interface CustomCatalogApiInterface
{
    /**
     * POST for test api
     * @param mixed $entity_id
     * @param mixed $copy_writeinfo
     * @param mixed $vpn
     * @return string
     */ 
    public function setcustomcatalog($entity_id,$copy_writeinfo,$vpn);
    
}
