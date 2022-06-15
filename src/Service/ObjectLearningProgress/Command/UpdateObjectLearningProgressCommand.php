<?php

namespace FluxIliasApi\Service\ObjectLearningProgress\Command;

use FluxIliasApi\Adapter\Object\ObjectDto;
use FluxIliasApi\Adapter\ObjectLearningProgress\LegacyObjectLearningProgress;
use FluxIliasApi\Adapter\ObjectLearningProgress\ObjectLearningProgressIdDto;
use FluxIliasApi\Adapter\User\UserDto;
use FluxIliasApi\Service\Object\Port\ObjectService;
use FluxIliasApi\Service\ObjectLearningProgress\ObjectLearningProgressMapping;
use FluxIliasApi\Service\ObjectLearningProgress\ObjectLearningProgressQuery;
use FluxIliasApi\Service\User\Port\UserService;
use ilLPStatus;

class UpdateObjectLearningProgressCommand
{

    use ObjectLearningProgressQuery;

    private ObjectService $object_service;
    private UserService $user_service;


    private function __construct(
        /*private readonly*/ ObjectService $object_service,
        /*private readonly*/ UserService $user_service
    ) {
        $this->object_service = $object_service;
        $this->user_service = $user_service;
    }


    public static function new(
        ObjectService $object_service,
        UserService $user_service
    ) : static {
        return new static(
            $object_service,
            $user_service
        );
    }


    public function updateObjectLearningProgressByIdByUserId(int $id, int $user_id, LegacyObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->updateObjectLearningProgress(
            $this->object_service->getObjectById(
                $id,
                false
            ),
            $this->user_service->getUserById(
                $user_id
            ),
            $learning_progress
        );
    }


    public function updateObjectLearningProgressByIdByUserImportId(int $id, string $user_import_id, LegacyObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->updateObjectLearningProgress(
            $this->object_service->getObjectById(
                $id,
                false
            ),
            $this->user_service->getUserByImportId(
                $user_import_id
            ),
            $learning_progress
        );
    }


    public function updateObjectLearningProgressByImportIdByUserId(string $import_id, int $user_id, LegacyObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->updateObjectLearningProgress(
            $this->object_service->getObjectByImportId(
                $import_id,
                false
            ),
            $this->user_service->getUserById(
                $user_id
            ),
            $learning_progress
        );
    }


    public function updateObjectLearningProgressByImportIdByUserImportId(string $import_id, string $user_import_id, LegacyObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->updateObjectLearningProgress(
            $this->object_service->getObjectByImportId(
                $import_id,
                false
            ),
            $this->user_service->getUserByImportId(
                $user_import_id
            ),
            $learning_progress
        );
    }


    public function updateObjectLearningProgressByRefIdByUserId(int $ref_id, int $user_id, LegacyObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->updateObjectLearningProgress(
            $this->object_service->getObjectByRefId(
                $ref_id,
                false
            ),
            $this->user_service->getUserById(
                $user_id
            ),
            $learning_progress
        );
    }


    public function updateObjectLearningProgressByRefIdByUserImportId(int $ref_id, string $user_import_id, LegacyObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->updateObjectLearningProgress(
            $this->object_service->getObjectByRefId(
                $ref_id,
                false
            ),
            $this->user_service->getUserByImportId(
                $user_import_id
            ),
            $learning_progress
        );
    }


    private function updateObjectLearningProgress(?ObjectDto $object, ?UserDto $user, LegacyObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        if ($object === null || $user === null) {
            return null;
        }

        ilLPStatus::writeStatus($object->id, $user->id, ObjectLearningProgressMapping::mapExternalToInternal($learning_progress)->value);

        return ObjectLearningProgressIdDto::new(
            $object->id,
            $object->import_id,
            $object->ref_id,
            $user->id,
            $user->import_id
        );
    }
}
