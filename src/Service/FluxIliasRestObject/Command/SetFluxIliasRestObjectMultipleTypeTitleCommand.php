<?php

namespace FluxIliasApi\Service\FluxIliasRestObject\Command;

use FluxIliasApi\Service\Config\LegacyConfigKey;
use FluxIliasApi\Service\Config\Port\ConfigService;

class SetFluxIliasRestObjectMultipleTypeTitleCommand
{

    private function __construct(
        private readonly ConfigService $config_service
    ) {

    }


    public static function new(
        ConfigService $config_service
    ) : static {
        return new static(
            $config_service
        );
    }


    public function setFluxIliasRestObjectMultipleTypeTitle(?string $multiple_type_title) : void
    {
        $this->config_service->setConfig(
            LegacyConfigKey::FLUX_ILIAS_REST_OBJECT_MULTIPLE_TYPE_TITLE(),
            $multiple_type_title
        );
    }
}