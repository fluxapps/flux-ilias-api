<?php

namespace FluxIliasApi\Channel\Category\Command;

use FluxIliasApi\Adapter\Category\CategoryDiffDto;
use FluxIliasApi\Adapter\Object\ObjectDto;
use FluxIliasApi\Adapter\Object\ObjectIdDto;
use FluxIliasApi\Channel\Category\CategoryQuery;
use FluxIliasApi\Channel\CustomMetadata\CustomMetadataQuery;
use FluxIliasApi\Channel\Object\Port\ObjectService;
use ilDBInterface;

class CreateCategoryCommand
{

    use CategoryQuery;
    use CustomMetadataQuery;

    private ilDBInterface $ilias_database;
    private ObjectService $object_service;


    private function __construct(
        /*private readonly*/ ObjectService $object_service,
        /*private readonly*/ ilDBInterface $ilias_database
    ) {
        $this->object_service = $object_service;
        $this->ilias_database = $ilias_database;
    }


    public static function new(
        ObjectService $object_service,
        ilDBInterface $ilias_database
    ) : /*static*/ self
    {
        return new static(
            $object_service,
            $ilias_database
        );
    }


    public function createCategoryToId(int $parent_id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createCategory(
            $this->object_service->getObjectById(
                $parent_id,
                false
            ),
            $diff
        );
    }


    public function createCategoryToImportId(string $parent_import_id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createCategory(
            $this->object_service->getObjectByImportId(
                $parent_import_id,
                false
            ),
            $diff
        );
    }


    public function createCategoryToRefId(int $parent_ref_id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createCategory(
            $this->object_service->getObjectByRefId(
                $parent_ref_id,
                false
            ),
            $diff
        );
    }


    private function createCategory(?ObjectDto $parent_object, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        if ($parent_object === null || $parent_object->ref_id === null) {
            return null;
        }

        $ilias_category = $this->newIliasCategory();

        $ilias_category->setTitle($diff->title ?? "");

        $ilias_category->create();
        $ilias_category->createReference();
        $ilias_category->putInTree($parent_object->ref_id);
        $ilias_category->setPermissions($parent_object->ref_id);

        $this->mapCategoryDiff(
            $diff,
            $ilias_category
        );

        $ilias_category->update();

        return ObjectIdDto::new(
            $ilias_category->getId() ?: null,
            $diff->import_id,
            $ilias_category->getRefId() ?: null
        );
    }
}
