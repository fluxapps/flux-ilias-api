<?php

namespace FluxIliasApi\Service\FluxIliasRestObject\Command;

use FluxIliasApi\Adapter\FluxIliasRestObject\FluxIliasRestObjectDiffDto;
use FluxIliasApi\Adapter\Object\ObjectDto;
use FluxIliasApi\Adapter\Object\ObjectIdDto;
use FluxIliasApi\Service\FluxIliasRestObject\FluxIliasRestObjectQuery;
use FluxIliasApi\Service\FluxIliasRestObject\Port\FluxIliasRestObjectService;
use FluxIliasApi\Service\Object\Port\ObjectService;
use ilDBInterface;

class CreateFluxIliasRestObjectCommand
{

    use FluxIliasRestObjectQuery;

    private FluxIliasRestObjectService $flux_ilias_rest_object_service;
    private ilDBInterface $ilias_database;
    private ObjectService $object_service;


    private function __construct(
        /*private readonly*/ FluxIliasRestObjectService $flux_ilias_rest_object_service,
        /*private readonly*/ ObjectService $object_service,
        /*private readonly*/ ilDBInterface $ilias_database
    ) {
        $this->flux_ilias_rest_object_service = $flux_ilias_rest_object_service;
        $this->object_service = $object_service;
        $this->ilias_database = $ilias_database;
    }


    public static function new(
        FluxIliasRestObjectService $flux_ilias_rest_object_service,
        ObjectService $object_service,
        ilDBInterface $ilias_database
    ) : static {
        return new static(
            $flux_ilias_rest_object_service,
            $object_service,
            $ilias_database
        );
    }


    public function createFluxIliasRestObjectToId(int $parent_id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createFluxIliasRestObject(
            $this->object_service->getObjectById(
                $parent_id,
                false
            ),
            $diff
        );
    }


    public function createFluxIliasRestObjectToImportId(string $parent_import_id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createFluxIliasRestObject(
            $this->object_service->getObjectByImportId(
                $parent_import_id,
                false
            ),
            $diff
        );
    }


    public function createFluxIliasRestObjectToRefId(int $parent_ref_id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createFluxIliasRestObject(
            $this->object_service->getObjectByRefId(
                $parent_ref_id,
                false
            ),
            $diff
        );
    }


    private function createFluxIliasRestObject(?ObjectDto $parent_object, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        if ($parent_object === null || $parent_object->ref_id === null) {
            return null;
        }

        $ilias_flux_ilias_rest_object = $this->newFluxIliasRestObject();

        $ilias_flux_ilias_rest_object->setTitle($diff->title ?? "");

        $ilias_flux_ilias_rest_object->create();
        $ilias_flux_ilias_rest_object->createReference();
        $ilias_flux_ilias_rest_object->putInTree($parent_object->ref_id);
        $ilias_flux_ilias_rest_object->setPermissions($parent_object->ref_id);

        $this->mapFluxIliasRestObjectDiff(
            $diff,
            $ilias_flux_ilias_rest_object
        );

        $ilias_flux_ilias_rest_object->update();

        return ObjectIdDto::new(
            $ilias_flux_ilias_rest_object->getId() ?: null,
            $diff->import_id,
            $ilias_flux_ilias_rest_object->getRefId() ?: null
        );
    }
}
