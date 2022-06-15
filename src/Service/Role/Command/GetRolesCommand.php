<?php

namespace FluxIliasApi\Service\Role\Command;

use FluxIliasApi\Adapter\Role\RoleDto;
use FluxIliasApi\Service\Role\RoleQuery;
use ilDBInterface;

class GetRolesCommand
{

    use RoleQuery;

    private ilDBInterface $ilias_database;


    private function __construct(
        /*private readonly*/ ilDBInterface $ilias_database
    ) {
        $this->ilias_database = $ilias_database;
    }


    public static function new(
        ilDBInterface $ilias_database
    ) : static {
        return new static(
            $ilias_database
        );
    }


    /**
     * @return RoleDto[]
     */
    public function getRoles() : array
    {
        return array_map([$this, "mapRoleDto"], $this->ilias_database->fetchAll($this->ilias_database->query($this->getRoleQuery())));
    }
}
