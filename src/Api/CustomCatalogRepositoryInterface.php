<?php
namespace Altayer\CustomCatalog\Api;

use Altayer\CustomCatalog\Api\Data\CustomCatalogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface CustomCatalogRepositoryInterface
 *
 * @api
 */
interface CustomCatalogRepositoryInterface
{
    /**
     * Create or update a CustomCatalog.
     *
     * @param CustomCatalogInterface $page
     * @return CustomCatalogInterface
     */
    public function save(CustomCatalogInterface $page);

    /**
     * Get a CustomCatalog by Id
     *
     * @param int $id
     * @return CustomCatalogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If CustomCatalog with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve CustomCatalogs which match a specified criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return       ( description_of_the_return_value )
     */
    public function getList(SearchCriteriaInterface $criteria);

    /**
     * Delete a CustomCatalog
     *
     * @param CustomCatalogInterface $page
     * @return CustomCatalogInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException If CustomCatalog with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(CustomCatalogInterface $page);

    /**
     * Delete a CustomCatalog by Id
     *
     * @param int $id
     * @return CustomCatalogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);

    /**
     * Get a CustomCatalog by Id
     *
     * @param string $vpn
     * @return CustomCatalogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If CustomCatalog with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */

    public function getbyvpn($vpn);

    /**
     * POST for test api
     * @param mixed $entity_id
     * @param mixed $copy_writeinfo
     * @param mixed $vpn
     * @return string
     */
    public function setcustomcatalog($entity_id,$copy_writeinfo,$vpn);



}
