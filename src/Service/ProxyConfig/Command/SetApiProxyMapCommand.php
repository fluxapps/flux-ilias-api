<?php

namespace FluxIliasApi\Service\ProxyConfig\Command;

use FluxIliasApi\Adapter\Proxy\ApiProxyMapDto;
use FluxIliasApi\Service\Config\LegacyConfigKey;
use FluxIliasApi\Service\Config\Port\ConfigService;

class SetApiProxyMapCommand
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


    /**
     * @param ApiProxyMapDto[] $api_proxy_map
     */
    public function setApiProxyMap(array $api_proxy_map) : void
    {
        $this->config_service->setConfig(
            LegacyConfigKey::API_PROXY_MAP(),
            $api_proxy_map
        );
    }
}
