<?php

namespace FluxIliasApi\Service\Change\Command;

use FluxIliasApi\Service\Config\LegacyConfigKey;
use FluxIliasApi\Service\Config\Port\ConfigService;

class SetKeepChangesInsideDaysCommand
{

    private ConfigService $config_service;


    private function __construct(
        /*private readonly*/ ConfigService $config_service
    ) {
        $this->config_service = $config_service;
    }


    public static function new(
        ConfigService $config_service
    ) : static {
        return new static(
            $config_service
        );
    }


    public function setKeepChangesInsideDays(?int $keep_changes_inside_days) : void
    {
        $this->config_service->setConfig(
            LegacyConfigKey::KEEP_CHANGES_INSIDE_DAYS(),
            max(0, $keep_changes_inside_days ?? GetKeepChangesInsideDaysCommand::DEFAULT_VALUE)
        );
    }
}
