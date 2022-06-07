<?php

namespace FluxIliasApi\Channel\ProxyConfig\Command;

use FluxIliasApi\Adapter\Proxy\WebProxyMapDto;

class GetWebProxyMapByKeyCommand
{

    /**
     * @var WebProxyMapDto[]
     */
    private array $web_proxy_map;


    /**
     * @param WebProxyMapDto[] $web_proxy_map
     */
    private function __construct(
        /*private readonly*/ array $web_proxy_map
    ) {
        $this->web_proxy_map = $web_proxy_map;
    }


    /**
     * @param WebProxyMapDto[] $web_proxy_map
     */
    public static function new(
        array $web_proxy_map
    ) : /*static*/ self
    {
        return new static(
            $web_proxy_map
        );
    }


    public function getWebProxyMapByKey(string $key) : ?WebProxyMapDto
    {
        foreach ($this->web_proxy_map as $web_proxy_map_dto) {
            if ($web_proxy_map_dto->target_key === $key) {
                return $web_proxy_map_dto;
            }
        }

        return null;
    }
}
