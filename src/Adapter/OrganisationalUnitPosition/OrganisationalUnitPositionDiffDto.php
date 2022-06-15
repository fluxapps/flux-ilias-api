<?php

namespace FluxIliasApi\Adapter\OrganisationalUnitPosition;

class OrganisationalUnitPositionDiffDto
{

    /**
     * @var OrganisationalUnitPositionAuthorityDto[]|null
     */
    public ?array $authorities;
    public ?string $description;
    public ?string $title;


    /**
     * @param OrganisationalUnitPositionAuthorityDto[]|null $authorities
     */
    private function __construct(
        /*public readonly*/ ?string $title,
        /*public readonly*/ ?string $description,
        /*public readonly*/ ?array $authorities
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->authorities = $authorities;
    }


    /**
     * @param OrganisationalUnitPositionAuthorityDto[]|null $authorities
     */
    public static function new(
        ?string $title = null,
        ?string $description = null,
        ?array $authorities = null
    ) : static {
        return new static(
            $title,
            $description,
            $authorities
        );
    }


    public static function newFromObject(
        object $diff
    ) : static {
        return static::new(
            $diff->title ?? null,
            $diff->description ?? null,
            ($authorities = $diff->authorities ?? null) !== null ? array_map([OrganisationalUnitPositionAuthorityDto::class, "newFromObject"], $authorities) : null
        );
    }
}
