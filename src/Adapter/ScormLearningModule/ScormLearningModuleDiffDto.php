<?php

namespace FluxIliasApi\Adapter\ScormLearningModule;

class ScormLearningModuleDiffDto
{

    public ?bool $authoring_mode;
    public ?string $description;
    public ?int $didactic_template_id;
    public ?string $import_id;
    public ?bool $online;
    public ?bool $sequencing_expert_mode;
    public ?string $title;
    public ?LegacyScormLearningModuleType $type;


    private function __construct(
        /*public readonly*/ ?string $import_id,
        /*public readonly*/ ?string $title,
        /*public readonly*/ ?string $description,
        /*public readonly*/ ?LegacyScormLearningModuleType $type,
        /*public readonly*/ ?bool $online,
        /*public readonly*/ ?bool $authoring_mode,
        /*public readonly*/ ?bool $sequencing_expert_mode,
        /*public readonly*/ ?int $didactic_template_id
    ) {
        $this->import_id = $import_id;
        $this->title = $title;
        $this->description = $description;
        $this->type = $type;
        $this->online = $online;
        $this->authoring_mode = $authoring_mode;
        $this->sequencing_expert_mode = $sequencing_expert_mode;
        $this->didactic_template_id = $didactic_template_id;
    }


    public static function new(
        ?string $import_id = null,
        ?string $title = null,
        ?string $description = null,
        ?LegacyScormLearningModuleType $type = null,
        ?bool $online = null,
        ?bool $authoring_mode = null,
        ?bool $sequencing_expert_mode = null,
        ?int $didactic_template_id = null
    ) : /*static*/ self
    {
        return new static(
            $import_id,
            $title,
            $description,
            $type,
            $online,
            $authoring_mode,
            $sequencing_expert_mode,
            $didactic_template_id
        );
    }


    public static function newFromData(
        object $data
    ) : /*static*/ self
    {
        return static::new(
            $data->import_id ?? null,
            $data->title ?? null,
            $data->description ?? null,
            ($type = $data->type ?? null) !== null ? LegacyScormLearningModuleType::from($type) : null,
            $data->online ?? null,
            $data->authoring_mode ?? null,
            $data->sequencing_expert_mode ?? null,
            $data->didactic_template_id ?? null
        );
    }
}
