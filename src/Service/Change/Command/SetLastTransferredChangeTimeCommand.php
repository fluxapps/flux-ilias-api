<?php

namespace FluxIliasApi\Service\Change\Command;

use FluxIliasApi\Service\Config\LegacyConfigKey;
use FluxIliasApi\Service\Config\Port\ConfigService;

class SetLastTransferredChangeTimeCommand
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


    public function setLastTransferredChangeTime(float $last_transferred_change_time) : void
    {
        $this->config_service->setConfig(
            LegacyConfigKey::LAST_TRANSFERRED_CHANGE_TIME(),
            $last_transferred_change_time
        );
    }
}
