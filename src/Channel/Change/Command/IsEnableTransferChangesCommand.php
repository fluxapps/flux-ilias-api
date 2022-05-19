<?php

namespace FluxIliasApi\Channel\Change\Command;

use FluxIliasApi\Channel\Change\Port\ChangeService;
use FluxIliasApi\Channel\CronConfig\Port\CronConfigService;

class IsEnableTransferChangesCommand
{

    private ChangeService $change_service;
    private CronConfigService $cron_config_service;


    private function __construct(
        /*private readonly*/ ChangeService $change_service,
        /*private readonly*/ CronConfigService $cron_config_service
    ) {
        $this->change_service = $change_service;
        $this->cron_config_service = $cron_config_service;
    }


    public static function new(
        ChangeService $change_service,
        CronConfigService $cron_config_service
    ) : /*static*/ self
    {
        return new static(
            $change_service,
            $cron_config_service
        );
    }


    public function isEnableTransferChanges() : bool
    {
        return $this->cron_config_service->isCronJobEnabled(
            $this->change_service->getTransferChangesCronJob()
        );
    }
}