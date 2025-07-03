<?php

namespace StreetSignal\Modules\V5\Repository\HXL;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use StreetSignal\Modules\V5\DTO\Paging;
use StreetSignal\Modules\V5\DTO\HXLTagSearchFields;
use StreetSignal\Modules\V5\DTO\HXLMetadataSearchFields;
use StreetSignal\Modules\V5\DTO\HXLOrganizationSearchFields;
use StreetSignal\Modules\V5\DTO\HXLLicenseSearchFields;
use StreetSignal\Modules\V5\Models\HXL\HXLMetaData;
use StreetSignal\Core\Entity\HXL\HXLMetadata as HXLMetadataEntity;

interface HXLRepository
{

    /**
     * This method will fetch list of the HXL Tags for the logged user from the database utilising
     * Laravel Eloquent ORM and return them as an array
     * @param int $limit
     * @param int $skip
     * @param string $sortBy
     * @param string $order
     * @param HXLTagSearchFields user_search_fields
     * @return LengthAwarePaginator
     */
    public function fetchTags(Paging $paging, HXLTagSearchFields $search_fields): LengthAwarePaginator;


     /**
     * This method will fetch list of the HXL Tags for the logged user from the database utilising
     * Laravel Eloquent ORM and return them as an array
     * @param int $limit
     * @param int $skip
     * @param string $sortBy
     * @param string $order
     * @param HXLOrganizationSearchFields user_search_fields
     * @return LengthAwarePaginator
     */
    public function fetchOrganization(Paging $paging, HXLOrganizationSearchFields $search_fields): LengthAwarePaginator;



     /**
     * This method will fetch list of the HXL Tags for the logged user from the database utilising
     * Laravel Eloquent ORM and return them as an array
     * @param int $limit
     * @param int $skip
     * @param string $sortBy
     * @param string $order
     * @param HXLMetadataSearchFields user_search_fields
     * @return LengthAwarePaginator
     */
    public function fetchMetadata(Paging $paging, HXLMetadataSearchFields $search_fields): LengthAwarePaginator;


     /**
     * This method will fetch a HXML Metadata by id
     * @param int $id
     * @return HXLMetaData
     */
    public function fetchHXLMetadataById(int $id): HXLMetaData;


     /**
     * This method will fetch list of the HXL Tags for the logged user from the database utilising
     * Laravel Eloquent ORM and return them as an array
     * @param int $limit
     * @param int $skip
     * @param string $sortBy
     * @param string $order
     * @param HXLLicenseSearchFields user_search_fields
     * @return LengthAwarePaginator
     */
    public function fetchLicenses(Paging $paging, HXLLicenseSearchFields $search_fields): LengthAwarePaginator;

   
    /**
     * This method will create a HXL
     * @param HXLMetadataEntity $entity
     * @return int
     */
    public function create(HXLMetadataEntity $entity): int;
}
