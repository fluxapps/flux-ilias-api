<?php

namespace FluxIliasApi\Service\ScormLearningModule\Command;

use FluxIliasApi\Adapter\Object\ObjectIdDto;
use FluxIliasApi\Adapter\ScormLearningModule\ScormLearningModuleDiffDto;
use FluxIliasApi\Adapter\ScormLearningModule\ScormLearningModuleDto;
use FluxIliasApi\Service\ScormLearningModule\Port\ScormLearningModuleService;
use FluxIliasApi\Service\ScormLearningModule\ScormLearningModuleQuery;

class UpdateScormLearningModuleCommand
{

    use ScormLearningModuleQuery;

    private ScormLearningModuleService $scorm_learning_module_service;


    private function __construct(
        /*private readonly*/ ScormLearningModuleService $scorm_learning_module_service
    ) {
        $this->scorm_learning_module_service = $scorm_learning_module_service;
    }


    public static function new(
        ScormLearningModuleService $scorm_learning_module_service
    ) : static {
        return new static(
            $scorm_learning_module_service
        );
    }


    public function updateScormLearningModuleById(int $id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->updateScormLearningModule(
            $this->scorm_learning_module_service->getScormLearningModuleById(
                $id,
                false
            ),
            $diff
        );
    }


    public function updateScormLearningModuleByImportId(string $import_id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->updateScormLearningModule(
            $this->scorm_learning_module_service->getScormLearningModuleByImportId(
                $import_id,
                false
            ),
            $diff
        );
    }


    public function updateScormLearningModuleByRefId(int $ref_id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->updateScormLearningModule(
            $this->scorm_learning_module_service->getScormLearningModuleByRefId(
                $ref_id,
                false
            ),
            $diff
        );
    }


    private function updateScormLearningModule(?ScormLearningModuleDto $scorm_learning_module, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        if ($scorm_learning_module === null) {
            return null;
        }

        $ilias_scorm_learning_module = $this->getIliasScormLearningModule(
            $scorm_learning_module->id,
            $scorm_learning_module->ref_id
        );
        if ($ilias_scorm_learning_module === null) {
            return null;
        }

        $this->mapScormLearningModuleDiff(
            $diff,
            $ilias_scorm_learning_module
        );

        $ilias_scorm_learning_module->update();

        return ObjectIdDto::new(
            $scorm_learning_module->id,
            $diff->import_id ?? $scorm_learning_module->import_id,
            $scorm_learning_module->ref_id
        );
    }
}
