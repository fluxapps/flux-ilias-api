<?php

namespace FluxIliasApi\Service\UserFavourite\Command;

use FluxIliasApi\Adapter\UserFavourite\UserFavouriteDto;
use FluxIliasApi\Service\UserFavourite\UserFavouriteQuery;
use ilDBInterface;

class GetUserFavouritesCommand
{

    use UserFavouriteQuery;

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
     * @return UserFavouriteDto[]
     */
    public function getUserFavourites(?int $user_id = null, ?string $user_import_id = null, ?int $object_id = null, ?string $object_import_id = null, ?int $object_ref_id = null) : array
    {
        return array_map([$this, "mapUserFavouriteDto"], $this->ilias_database->fetchAll($this->ilias_database->query($this->getUserFavouriteQuery(
            $user_id,
            $user_import_id,
            $object_id,
            $object_import_id,
            $object_ref_id
        ))));
    }
}
