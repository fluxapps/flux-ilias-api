<?php

namespace FluxIliasApi\Adapter\Api;

use FluxIliasApi\Adapter\CronConfig\Wrapper\IliasCronWrapper;
use FluxIliasApi\Adapter\CronConfig\Wrapper\LegacyIliasCronWrapper;
use FluxIliasApi\Adapter\CronConfig\Wrapper\NewIliasCronWrapper;
use FluxIliasApi\Adapter\Menu\MenuProvider;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Category\CategoryDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Category\CategoryDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Change\ChangeDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Course\CourseDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Course\CourseDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\CourseMember\CourseMemberDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\CourseMember\CourseMemberDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\CourseMember\CourseMemberIdDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\File\FileDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\File\FileDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\FluxIliasRestObject\FluxIliasRestObjectDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\FluxIliasRestObject\FluxIliasRestObjectDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Group\GroupDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Group\GroupDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\GroupMember\GroupMemberDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\GroupMember\GroupMemberDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\GroupMember\GroupMemberIdDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Object\ObjectDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Object\ObjectDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Object\ObjectIdDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Object\ObjectType;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\ObjectLearningProgress\ObjectLearningProgress;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\ObjectLearningProgress\ObjectLearningProgressDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\ObjectLearningProgress\ObjectLearningProgressIdDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\OrganisationalUnit\OrganisationalUnitDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\OrganisationalUnit\OrganisationalUnitDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\OrganisationalUnit\OrganisationalUnitIdDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\OrganisationalUnitPosition\OrganisationalUnitPositionCoreIdentifier;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\OrganisationalUnitPosition\OrganisationalUnitPositionDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\OrganisationalUnitPosition\OrganisationalUnitPositionDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\OrganisationalUnitPosition\OrganisationalUnitPositionIdDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\OrganisationalUnitStaff\OrganisationalUnitStaffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Permission\Permission;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Role\RoleDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\Role\RoleDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\ScormLearningModule\ScormLearningModuleDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\ScormLearningModule\ScormLearningModuleDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\User\UserDiffDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\User\UserDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\User\UserIdDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\UserFavourite\UserFavouriteDto;
use FluxIliasApi\Libs\FluxIliasBaseApi\Adapter\UserRole\UserRoleDto;
use FluxIliasApi\Libs\FluxRestApi\Adapter\Api\RestApi;
use FluxIliasApi\Service\Category\Port\CategoryService;
use FluxIliasApi\Service\Change\Port\ChangeService;
use FluxIliasApi\Service\Config\Port\ConfigService;
use FluxIliasApi\Service\ConfigForm\Port\ConfigFormService;
use FluxIliasApi\Service\Course\Port\CourseService;
use FluxIliasApi\Service\CourseMember\Port\CourseMemberService;
use FluxIliasApi\Service\Cron\Port\CronService;
use FluxIliasApi\Service\CronConfig\Port\CronConfigService;
use FluxIliasApi\Service\File\Port\FileService;
use FluxIliasApi\Service\FluxIliasRestObject\Port\FluxIliasRestObjectService;
use FluxIliasApi\Service\Group\Port\GroupService;
use FluxIliasApi\Service\GroupMember\Port\GroupMemberService;
use FluxIliasApi\Service\Menu\Port\MenuService;
use FluxIliasApi\Service\Object\Port\ObjectService;
use FluxIliasApi\Service\ObjectConfig\Port\ObjectConfigService;
use FluxIliasApi\Service\ObjectLearningProgress\Port\ObjectLearningProgressService;
use FluxIliasApi\Service\OrganisationalUnit\Port\OrganisationalUnitService;
use FluxIliasApi\Service\OrganisationalUnitPosition\Port\OrganisationalUnitPositionService;
use FluxIliasApi\Service\OrganisationalUnitStaff\Port\OrganisationalUnitStaffService;
use FluxIliasApi\Service\Proxy\Port\ProxyService;
use FluxIliasApi\Service\ProxyConfig\Port\ProxyConfigService;
use FluxIliasApi\Service\RestConfig\Port\RestConfigService;
use FluxIliasApi\Service\Role\Port\RoleService;
use FluxIliasApi\Service\ScormLearningModule\Port\ScormLearningModuleService;
use FluxIliasApi\Service\Setup\Port\SetupService;
use FluxIliasApi\Service\User\Port\UserService;
use FluxIliasApi\Service\UserFavourite\Port\UserFavouriteService;
use FluxIliasApi\Service\UserMail\Port\UserMailService;
use FluxIliasApi\Service\UserRole\Port\UserRoleService;
use ilAccessHandler;
use ilCronJob;
use ilCronServices;
use ilDBInterface;
use ilFavouritesDBRepository;
use ilGlobalTemplateInterface;
use ILIAS\DI\Container;
use ILIAS\DI\RBACServices;
use ILIAS\FileUpload\FileUpload;
use ilLocatorGUI;
use ilObjectDefinition;
use ilObjUser;
use ilPlugin;
use ilTree;

class IliasApi
{

    private function __construct()
    {

    }


    public static function new() : static
    {
        return new static();
    }


    public function addCourseMemberByIdByUserId(int $id, int $user_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->addCourseMemberByIdByUserId(
                $id,
                $user_id,
                $diff
            );
    }


    public function addCourseMemberByIdByUserImportId(int $id, string $user_import_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->addCourseMemberByIdByUserImportId(
                $id,
                $user_import_id,
                $diff
            );
    }


    public function addCourseMemberByImportIdByUserId(string $import_id, int $user_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->addCourseMemberByImportIdByUserId(
                $import_id,
                $user_id,
                $diff
            );
    }


    public function addCourseMemberByImportIdByUserImportId(string $import_id, string $user_import_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->addCourseMemberByImportIdByUserImportId(
                $import_id,
                $user_import_id,
                $diff
            );
    }


    public function addCourseMemberByRefIdByUserId(int $ref_id, int $user_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->addCourseMemberByRefIdByUserId(
                $ref_id,
                $user_id,
                $diff
            );
    }


    public function addCourseMemberByRefIdByUserImportId(int $ref_id, string $user_import_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->addCourseMemberByRefIdByUserImportId(
                $ref_id,
                $user_import_id,
                $diff
            );
    }


    public function addGroupMemberByIdByUserId(int $id, int $user_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->addGroupMemberByIdByUserId(
                $id,
                $user_id,
                $diff
            );
    }


    public function addGroupMemberByIdByUserImportId(int $id, string $user_import_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->addGroupMemberByIdByUserImportId(
                $id,
                $user_import_id,
                $diff
            );
    }


    public function addGroupMemberByImportIdByUserId(string $import_id, int $user_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->addGroupMemberByImportIdByUserId(
                $import_id,
                $user_id,
                $diff
            );
    }


    public function addGroupMemberByImportIdByUserImportId(string $import_id, string $user_import_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->addGroupMemberByImportIdByUserImportId(
                $import_id,
                $user_import_id,
                $diff
            );
    }


    public function addGroupMemberByRefIdByUserId(int $ref_id, int $user_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->addGroupMemberByRefIdByUserId(
                $ref_id,
                $user_id,
                $diff
            );
    }


    public function addGroupMemberByRefIdByUserImportId(int $ref_id, string $user_import_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->addGroupMemberByRefIdByUserImportId(
                $ref_id,
                $user_import_id,
                $diff
            );
    }


    public function addOrganisationalUnitStaffByExternalIdByUserId(string $external_id, int $user_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->addOrganisationalUnitStaffByExternalIdByUserId(
                $external_id,
                $user_id,
                $position_id
            );
    }


    public function addOrganisationalUnitStaffByExternalIdByUserImportId(string $external_id, string $user_import_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->addOrganisationalUnitStaffByExternalIdByUserImportId(
                $external_id,
                $user_import_id,
                $position_id
            );
    }


    public function addOrganisationalUnitStaffByIdByUserId(int $id, int $user_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->addOrganisationalUnitStaffByIdByUserId(
                $id,
                $user_id,
                $position_id
            );
    }


    public function addOrganisationalUnitStaffByIdByUserImportId(int $id, string $user_import_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->addOrganisationalUnitStaffByIdByUserImportId(
                $id,
                $user_import_id,
                $position_id
            );
    }


    public function addOrganisationalUnitStaffByRefIdByUserId(int $ref_id, int $user_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->addOrganisationalUnitStaffByRefIdByUserId(
                $ref_id,
                $user_id,
                $position_id
            );
    }


    public function addOrganisationalUnitStaffByRefIdByUserImportId(int $ref_id, string $user_import_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->addOrganisationalUnitStaffByRefIdByUserImportId(
                $ref_id,
                $user_import_id,
                $position_id
            );
    }


    public function addUserFavouriteByIdByObjectId(int $id, int $object_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->addUserFavouriteByIdByObjectId(
                $id,
                $object_id
            );
    }


    public function addUserFavouriteByIdByObjectImportId(int $id, string $object_import_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->addUserFavouriteByIdByObjectImportId(
                $id,
                $object_import_id
            );
    }


    public function addUserFavouriteByIdByObjectRefId(int $id, int $object_ref_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->addUserFavouriteByIdByObjectRefId(
                $id,
                $object_ref_id
            );
    }


    public function addUserFavouriteByImportIdByObjectId(string $import_id, int $object_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->addUserFavouriteByImportIdByObjectId(
                $import_id,
                $object_id
            );
    }


    public function addUserFavouriteByImportIdByObjectImportId(string $import_id, string $object_import_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->addUserFavouriteByImportIdByObjectImportId(
                $import_id,
                $object_import_id
            );
    }


    public function addUserFavouriteByImportIdByObjectRefId(string $import_id, int $object_ref_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->addUserFavouriteByImportIdByObjectRefId(
                $import_id,
                $object_ref_id
            );
    }


    public function addUserRoleByIdByRoleId(int $id, int $role_id) : ?UserRoleDto
    {
        return $this->getUserRoleService()
            ->addUserRoleByIdByRoleId(
                $id,
                $role_id
            );
    }


    public function addUserRoleByIdByRoleImportId(int $id, string $role_import_id) : ?UserRoleDto
    {
        return $this->getUserRoleService()
            ->addUserRoleByIdByRoleImportId(
                $id,
                $role_import_id
            );
    }


    public function addUserRoleByImportIdByRoleId(string $import_id, int $role_id) : ?UserRoleDto
    {
        return $this->getUserRoleService()
            ->addUserRoleByImportIdByRoleId(
                $import_id,
                $role_id
            );
    }


    public function addUserRoleByImportIdByRoleImportId(string $import_id, string $role_import_id) : ?UserRoleDto
    {
        return $this->getUserRoleService()
            ->addUserRoleByImportIdByRoleImportId(
                $import_id,
                $role_import_id
            );
    }


    public function cloneObjectByIdToId(int $id, int $parent_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByIdToId(
                $id,
                $parent_id,
                $link,
                $prefer_link
            );
    }


    public function cloneObjectByIdToImportId(int $id, string $parent_import_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByIdToImportId(
                $id,
                $parent_import_id,
                $link,
                $prefer_link
            );
    }


    public function cloneObjectByIdToRefId(int $id, int $parent_ref_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByIdToRefId(
                $id,
                $parent_ref_id,
                $link,
                $prefer_link
            );
    }


    public function cloneObjectByImportIdToId(string $import_id, int $parent_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByImportIdToId(
                $import_id,
                $parent_id,
                $link,
                $prefer_link
            );
    }


    public function cloneObjectByImportIdToImportId(string $import_id, string $parent_import_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByImportIdToImportId(
                $import_id,
                $parent_import_id,
                $link,
                $prefer_link
            );
    }


    public function cloneObjectByImportIdToRefId(string $import_id, int $parent_ref_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByImportIdToRefId(
                $import_id,
                $parent_ref_id,
                $link,
                $prefer_link
            );
    }


    public function cloneObjectByRefIdToId(int $ref_id, int $parent_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByRefIdToId(
                $ref_id,
                $parent_id,
                $link,
                $prefer_link
            );
    }


    public function cloneObjectByRefIdToImportId(int $ref_id, string $parent_import_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByRefIdToImportId(
                $ref_id,
                $parent_import_id,
                $link,
                $prefer_link
            );
    }


    public function cloneObjectByRefIdToRefId(int $ref_id, int $parent_ref_id, bool $link = false, bool $prefer_link = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->cloneObjectByRefIdToRefId(
                $ref_id,
                $parent_ref_id,
                $link,
                $prefer_link
            );
    }


    public function createCategoryToId(int $parent_id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCategoryService()
            ->createCategoryToId(
                $parent_id,
                $diff
            );
    }


    public function createCategoryToImportId(string $parent_import_id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCategoryService()
            ->createCategoryToImportId(
                $parent_import_id,
                $diff
            );
    }


    public function createCategoryToRefId(int $parent_ref_id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCategoryService()
            ->createCategoryToRefId(
                $parent_ref_id,
                $diff
            );
    }


    public function createCourseToId(int $parent_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCourseService()
            ->createCourseToId(
                $parent_id,
                $diff
            );
    }


    public function createCourseToImportId(string $parent_import_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCourseService()
            ->createCourseToImportId(
                $parent_import_id,
                $diff
            );
    }


    public function createCourseToRefId(int $parent_ref_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCourseService()
            ->createCourseToRefId(
                $parent_ref_id,
                $diff
            );
    }


    public function createFileToId(int $parent_id, FileDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->createFileToId(
                $parent_id,
                $diff
            );
    }


    public function createFileToImportId(string $parent_import_id, FileDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->createFileToImportId(
                $parent_import_id,
                $diff
            );
    }


    public function createFileToRefId(int $parent_ref_id, FileDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->createFileToRefId(
                $parent_ref_id,
                $diff
            );
    }


    public function createFluxIliasRestObjectToId(int $parent_id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFluxIliasRestObjectService()
            ->createFluxIliasRestObjectToId(
                $parent_id,
                $diff
            );
    }


    public function createFluxIliasRestObjectToImportId(string $parent_import_id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFluxIliasRestObjectService()
            ->createFluxIliasRestObjectToImportId(
                $parent_import_id,
                $diff
            );
    }


    public function createFluxIliasRestObjectToRefId(int $parent_ref_id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFluxIliasRestObjectService()
            ->createFluxIliasRestObjectToRefId(
                $parent_ref_id,
                $diff
            );
    }


    public function createGroupToId(int $parent_id, GroupDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getGroupService()
            ->createGroupToId(
                $parent_id,
                $diff
            );
    }


    public function createGroupToImportId(string $parent_import_id, GroupDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getGroupService()
            ->createGroupToImportId(
                $parent_import_id,
                $diff
            );
    }


    public function createGroupToRefId(int $parent_ref_id, GroupDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getGroupService()
            ->createGroupToRefId(
                $parent_ref_id,
                $diff
            );
    }


    public function createObjectToId(ObjectType $type, int $parent_id, ObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->createObjectToId(
                $type,
                $parent_id,
                $diff
            );
    }


    public function createObjectToImportId(ObjectType $type, string $parent_import_id, ObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->createObjectToImportId(
                $type,
                $parent_import_id,
                $diff
            );
    }


    public function createObjectToRefId(ObjectType $type, int $parent_ref_id, ObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->createObjectToRefId(
                $type,
                $parent_ref_id,
                $diff
            );
    }


    public function createOrganisationalUnitPosition(OrganisationalUnitPositionDiffDto $diff) : OrganisationalUnitPositionIdDto
    {
        return $this->getOrganisationalUnitPositionService()
            ->createOrganisationalUnitPosition(
                $diff
            );
    }


    public function createOrganisationalUnitToExternalId(string $parent_external_id, OrganisationalUnitDiffDto $diff) : ?OrganisationalUnitIdDto
    {
        return $this->getOrganisationalUnitService()
            ->createOrganisationalUnitToExternalId(
                $parent_external_id,
                $diff
            );
    }


    public function createOrganisationalUnitToId(int $parent_id, OrganisationalUnitDiffDto $diff) : ?OrganisationalUnitIdDto
    {
        return $this->getOrganisationalUnitService()
            ->createOrganisationalUnitToId(
                $parent_id,
                $diff
            );
    }


    public function createOrganisationalUnitToRefId(int $parent_ref_id, OrganisationalUnitDiffDto $diff) : ?OrganisationalUnitIdDto
    {
        return $this->getOrganisationalUnitService()
            ->createOrganisationalUnitToRefId(
                $parent_ref_id,
                $diff
            );
    }


    public function createRoleToId(int $object_id, RoleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getRoleService()
            ->createRoleToId(
                $object_id,
                $diff
            );
    }


    public function createRoleToImportId(string $object_import_id, RoleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getRoleService()
            ->createRoleToImportId(
                $object_import_id,
                $diff
            );
    }


    public function createRoleToRefId(int $object_ref_id, RoleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getRoleService()
            ->createRoleToRefId(
                $object_ref_id,
                $diff
            );
    }


    public function createScormLearningModuleToId(int $parent_id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->createScormLearningModuleToId(
                $parent_id,
                $diff
            );
    }


    public function createScormLearningModuleToImportId(string $parent_import_id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->createScormLearningModuleToImportId(
                $parent_import_id,
                $diff
            );
    }


    public function createScormLearningModuleToRefId(int $parent_ref_id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->createScormLearningModuleToRefId(
                $parent_ref_id,
                $diff
            );
    }


    public function createUser(UserDiffDto $diff) : UserIdDto
    {
        return $this->getUserService()
            ->createUser(
                $diff
            );
    }


    public function deleteObjectById(int $id, bool $force = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->deleteObjectById(
                $id,
                $force
            );
    }


    public function deleteObjectByImportId(string $import_id, bool $force = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->deleteObjectByImportId(
                $import_id,
                $force
            );
    }


    public function deleteObjectByRefId(int $ref_id, bool $force = false) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->deleteObjectByRefId(
                $ref_id,
                $force
            );
    }


    public function deleteObjectConfig(int $id) : void
    {
        $this->getObjectConfigService()
            ->deleteObjectConfig(
                $id
            );
    }


    public function deleteOrganisationalUnitPositionById(int $id) : ?OrganisationalUnitPositionIdDto
    {
        return $this->getOrganisationalUnitPositionService()
            ->deleteOrganisationalUnitPositionById(
                $id
            );
    }


    /**
     * @return CategoryDto[]
     */
    public function getCategories(?bool $in_trash = null) : array
    {
        return $this->getCategoryService()
            ->getCategories(
                $in_trash
            );
    }


    public function getCategoryById(int $id, ?bool $in_trash = null) : ?CategoryDto
    {
        return $this->getCategoryService()
            ->getCategoryById(
                $id,
                $in_trash
            );
    }


    public function getCategoryByImportId(string $import_id, ?bool $in_trash = null) : ?CategoryDto
    {
        return $this->getCategoryService()
            ->getCategoryByImportId(
                $import_id,
                $in_trash
            );
    }


    public function getCategoryByRefId(int $ref_id, ?bool $in_trash = null) : ?CategoryDto
    {
        return $this->getCategoryService()
            ->getCategoryByRefId(
                $ref_id,
                $in_trash
            );
    }


    /**
     * @return ChangeDto[]
     */
    public function getChanges(?float $from = null, ?float $to = null, ?float $after = null, ?float $before = null) : array
    {
        return $this->getChangeService()
            ->getChanges(
                $from,
                $to,
                $after,
                $before
            );
    }


    /**
     * @return ObjectDto[]|null
     */
    public function getChildrenById(int $id, ?ObjectType $type = null, ?string $title = null, bool $ref_ids = false, ?bool $in_trash = null) : ?array
    {
        return $this->getObjectService()
            ->getChildrenById(
                $id,
                $type,
                $title,
                $ref_ids,
                $in_trash
            );
    }


    /**
     * @return ObjectDto[]|null
     */
    public function getChildrenByImportId(string $import_id, ?ObjectType $type = null, ?string $title = null, bool $ref_ids = false, ?bool $in_trash = null) : ?array
    {
        return $this->getObjectService()
            ->getChildrenByImportId(
                $import_id,
                $type,
                $title,
                $ref_ids,
                $in_trash
            );
    }


    /**
     * @return ObjectDto[]|null
     */
    public function getChildrenByRefId(int $ref_id, ?ObjectType $type = null, ?string $title = null, bool $ref_ids = false, ?bool $in_trash = null) : ?array
    {
        return $this->getObjectService()
            ->getChildrenByRefId(
                $ref_id,
                $type,
                $title,
                $ref_ids,
                $in_trash
            );
    }


    public function getCourseById(int $id, ?bool $in_trash = null) : ?CourseDto
    {
        return $this->getCourseService()
            ->getCourseById(
                $id,
                $in_trash
            );
    }


    public function getCourseByImportId(string $import_id, ?bool $in_trash = null) : ?CourseDto
    {
        return $this->getCourseService()
            ->getCourseByImportId(
                $import_id,
                $in_trash
            );
    }


    public function getCourseByRefId(int $ref_id, ?bool $in_trash = null) : ?CourseDto
    {
        return $this->getCourseService()
            ->getCourseByRefId(
                $ref_id,
                $in_trash
            );
    }


    /**
     * @return CourseMemberDto[]
     */
    public function getCourseMembers(
        ?int $course_id = null,
        ?string $course_import_id = null,
        ?int $course_ref_id = null,
        ?int $user_id = null,
        ?string $user_import_id = null,
        ?bool $member_role = null,
        ?bool $tutor_role = null,
        ?bool $administrator_role = null,
        ?ObjectLearningProgress $learning_progress = null,
        ?bool $passed = null,
        ?bool $access_refused = null,
        ?bool $tutorial_support = null,
        ?bool $notification = null
    ) : array {
        return $this->getCourseMemberService()
            ->getCourseMembers(
                $course_id,
                $course_import_id,
                $course_ref_id,
                $user_id,
                $user_import_id,
                $member_role,
                $tutor_role,
                $administrator_role,
                $learning_progress,
                $passed,
                $access_refused,
                $tutorial_support,
                $notification
            );
    }


    /**
     * @return CourseDto[]
     */
    public function getCourses(bool $container_settings = false, ?bool $in_trash = null) : array
    {
        return $this->getCourseService()
            ->getCourses(
                $container_settings,
                $in_trash
            );
    }


    public function getCronJob(string $id) : ?ilCronJob
    {
        return $this->getCronService()
            ->getCronJob(
                $id
            );
    }


    /**
     * @return ilCronJob[]
     */
    public function getCronJobs() : array
    {
        return $this->getCronService()
            ->getCronJobs();
    }


    public function getCurrentApiUser() : ?UserDto
    {
        $id = $this->getIliasUser()->getId();
        if (intval($id) === intval(ANONYMOUS_USER_ID)) {
            return null;
        }

        return $this->getUserById(
            $id
        );
    }


    public function getCurrentWebUser(?string $session_id) : ?UserDto
    {
        return $this->getUserService()
            ->getCurrentWebUser(
                $session_id
            );
    }


    public function getFileById(int $id, ?bool $in_trash = null) : ?FileDto
    {
        return $this->getFileService()
            ->getFileById(
                $id,
                $in_trash
            );
    }


    public function getFileByImportId(string $import_id, ?bool $in_trash = null) : ?FileDto
    {
        return $this->getFileService()
            ->getFileByImportId(
                $import_id,
                $in_trash
            );
    }


    public function getFileByRefId(int $ref_id, ?bool $in_trash = null) : ?FileDto
    {
        return $this->getFileService()
            ->getFileByRefId(
                $ref_id,
                $in_trash
            );
    }


    /**
     * @return FileDto[]
     */
    public function getFiles(?bool $in_trash = null) : array
    {
        return $this->getFileService()
            ->getFiles(
                $in_trash
            );
    }


    public function getFluxIliasRestObjectById(int $id, ?bool $in_trash = null) : ?FluxIliasRestObjectDto
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjectById(
                $id,
                $in_trash
            );
    }


    public function getFluxIliasRestObjectByImportId(string $import_id, ?bool $in_trash = null) : ?FluxIliasRestObjectDto
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjectByImportId(
                $import_id,
                $in_trash
            );
    }


    public function getFluxIliasRestObjectByRefId(int $ref_id, ?bool $in_trash = null) : ?FluxIliasRestObjectDto
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjectByRefId(
                $ref_id,
                $in_trash
            );
    }


    public function getFluxIliasRestObjectConfigLink(int $ref_id) : string
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjectConfigLink(
                $ref_id
            );
    }


    public function getFluxIliasRestObjectWebIconUrl(?int $id = null) : string
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjectWebIconUrl(
                $id
            );
    }


    public function getFluxIliasRestObjectWebMultipleTypeTitle() : string
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjectWebMultipleTypeTitle();
    }


    public function getFluxIliasRestObjectWebProxyLink(int $ref_id, int $id) : string
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjectWebProxyLink(
                $ref_id,
                $id,
                $this->getIliasUser()->getId()
            );
    }


    public function getFluxIliasRestObjectWebTypeTitle() : string
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjectWebTypeTitle();
    }


    /**
     * @return FluxIliasRestObjectDto[]
     */
    public function getFluxIliasRestObjects(bool $container_settings = false, ?bool $in_trash = null) : array
    {
        return $this->getFluxIliasRestObjectService()
            ->getFluxIliasRestObjects(
                $container_settings,
                $in_trash
            );
    }


    public function getGlobalRoleObject() : ?ObjectDto
    {
        return $this->getRoleService()
            ->getGlobalRoleObject();
    }


    public function getGroupById(int $id, ?bool $in_trash = null) : ?GroupDto
    {
        return $this->getGroupService()
            ->getGroupById(
                $id,
                $in_trash
            );
    }


    public function getGroupByImportId(string $import_id, ?bool $in_trash = null) : ?GroupDto
    {
        return $this->getGroupService()
            ->getGroupByImportId(
                $import_id,
                $in_trash
            );
    }


    public function getGroupByRefId(int $ref_id, ?bool $in_trash = null) : ?GroupDto
    {
        return $this->getGroupService()
            ->getGroupByRefId(
                $ref_id,
                $in_trash
            );
    }


    /**
     * @return GroupMemberDto[]
     */
    public function getGroupMembers(
        ?int $group_id = null,
        ?string $group_import_id = null,
        ?int $group_ref_id = null,
        ?int $user_id = null,
        ?string $user_import_id = null,
        ?bool $member_role = null,
        ?bool $administrator_role = null,
        ?ObjectLearningProgress $learning_progress = null,
        ?bool $tutorial_support = null,
        ?bool $notification = null
    ) : array {
        return $this->getGroupMemberService()
            ->getGroupMembers(
                $group_id,
                $group_import_id,
                $group_ref_id,
                $user_id,
                $user_import_id,
                $member_role,
                $administrator_role,
                $learning_progress,
                $tutorial_support,
                $notification
            );
    }


    /**
     * @return GroupDto[]
     */
    public function getGroups(?bool $in_trash = null) : array
    {
        return $this->getGroupService()
            ->getGroups(
                $in_trash
            );
    }


    public function getMenuProvider(ilPlugin $ilias_plugin) : MenuProvider
    {
        return $this->getMenuService()
            ->getMenuProvider(
                $ilias_plugin,
                $this->getCurrentApiUser()
            );
    }


    public function getObjectById(int $id, ?bool $in_trash = null) : ?ObjectDto
    {
        return $this->getObjectService()
            ->getObjectById(
                $id,
                $in_trash
            );
    }


    public function getObjectByImportId(string $import_id, ?bool $in_trash = null) : ?ObjectDto
    {
        return $this->getObjectService()
            ->getObjectByImportId(
                $import_id,
                $in_trash
            );
    }


    public function getObjectByRefId(int $ref_id, ?bool $in_trash = null) : ?ObjectDto
    {
        return $this->getObjectService()
            ->getObjectByRefId(
                $ref_id,
                $in_trash
            );
    }


    /**
     * @return ObjectLearningProgressDto[]
     */
    public function getObjectLearningProgress(
        ?int $object_id = null,
        ?string $object_import_id = null,
        ?int $object_ref_id = null,
        ?int $user_id = null,
        ?string $user_import_id = null,
        ?ObjectLearningProgress $learning_progress = null
    ) : array {
        return $this->getObjectLearningProgressService()
            ->getObjectLearningProgress(
                $object_id,
                $object_import_id,
                $object_ref_id,
                $user_id,
                $user_import_id,
                $learning_progress
            );
    }


    /**
     * @return ObjectDto[]
     */
    public function getObjects(ObjectType $type, ?string $title = null, bool $ref_ids = false, ?bool $in_trash = null) : array
    {
        return $this->getObjectService()
            ->getObjects(
                $type,
                $title,
                $ref_ids,
                $in_trash
            );
    }


    public function getOrganisationalUnitByExternalId(string $external_id) : ?OrganisationalUnitDto
    {
        return $this->getOrganisationalUnitService()
            ->getOrganisationalUnitByExternalId(
                $external_id
            );
    }


    public function getOrganisationalUnitById(int $id) : ?OrganisationalUnitDto
    {
        return $this->getOrganisationalUnitService()
            ->getOrganisationalUnitById(
                $id
            );
    }


    public function getOrganisationalUnitByRefId(int $ref_id) : ?OrganisationalUnitDto
    {
        return $this->getOrganisationalUnitService()
            ->getOrganisationalUnitByRefId(
                $ref_id
            );
    }


    public function getOrganisationalUnitPositionByCoreIdentifier(OrganisationalUnitPositionCoreIdentifier $core_identifier) : ?OrganisationalUnitPositionDto
    {
        return $this->getOrganisationalUnitPositionService()
            ->getOrganisationalUnitPositionByCoreIdentifier(
                $core_identifier
            );
    }


    public function getOrganisationalUnitPositionById(int $id) : ?OrganisationalUnitPositionDto
    {
        return $this->getOrganisationalUnitPositionService()
            ->getOrganisationalUnitPositionById(
                $id
            );
    }


    /**
     * @return OrganisationalUnitPositionDto[]
     */
    public function getOrganisationalUnitPositions(bool $authorities = false) : array
    {
        return $this->getOrganisationalUnitPositionService()
            ->getOrganisationalUnitPositions(
                $authorities
            );
    }


    public function getOrganisationalUnitRoot() : ?OrganisationalUnitDto
    {
        return $this->getOrganisationalUnitService()
            ->getOrganisationalUnitRoot();
    }


    /**
     * @return OrganisationalUnitStaffDto[]
     */
    public function getOrganisationalUnitStaff(
        ?int $organisational_unit_id = null,
        ?string $organisational_unit_external_id = null,
        ?int $organisational_unit_ref_id = null,
        ?int $user_id = null,
        ?string $user_import_id = null,
        ?int $position_id = null
    ) : array {
        return $this->getOrganisationalUnitStaffService()
            ->getOrganisationalUnitStaff(
                $organisational_unit_id,
                $organisational_unit_external_id,
                $organisational_unit_ref_id,
                $user_id,
                $user_import_id,
                $position_id
            );
    }


    /**
     * @return OrganisationalUnitDto[]
     */
    public function getOrganisationalUnits() : array
    {
        return $this->getOrganisationalUnitService()
            ->getOrganisationalUnits();
    }


    /**
     * @return ObjectDto[]|null
     */
    public function getPathById(int $id, bool $ref_ids = false, ?bool $in_trash = null) : ?array
    {
        return $this->getObjectService()
            ->getPathById(
                $id,
                $ref_ids,
                $in_trash
            );
    }


    /**
     * @return ObjectDto[]|null
     */
    public function getPathByImportId(string $import_id, bool $ref_ids = false, ?bool $in_trash = null) : ?array
    {
        return $this->getObjectService()
            ->getPathByImportId(
                $import_id,
                $ref_ids,
                $in_trash
            );
    }


    /**
     * @return ObjectDto[]|null
     */
    public function getPathByRefId(int $ref_id, bool $ref_ids = false, ?bool $in_trash = null) : ?array
    {
        return $this->getObjectService()
            ->getPathByRefId(
                $ref_id,
                $ref_ids,
                $in_trash
            );
    }


    public function getRoleById(int $id) : ?RoleDto
    {
        return $this->getRoleService()
            ->getRoleById(
                $id
            );
    }


    public function getRoleByImportId(string $import_id) : ?RoleDto
    {
        return $this->getRoleService()
            ->getRoleByImportId(
                $import_id
            );
    }


    /**
     * @return RoleDto[]
     */
    public function getRoles() : array
    {
        return $this->getRoleService()
            ->getRoles();
    }


    public function getRootObject() : ?ObjectDto
    {
        return $this->getObjectService()
            ->getRootObject();
    }


    public function getScormLearningModuleById(int $id, ?bool $in_trash = null) : ?ScormLearningModuleDto
    {
        return $this->getScormLearningModuleService()
            ->getScormLearningModuleById(
                $id,
                $in_trash
            );
    }


    public function getScormLearningModuleByImportId(string $import_id, ?bool $in_trash = null) : ?ScormLearningModuleDto
    {
        return $this->getScormLearningModuleService()
            ->getScormLearningModuleByImportId(
                $import_id,
                $in_trash
            );
    }


    public function getScormLearningModuleByRefId(int $ref_id, ?bool $in_trash = null) : ?ScormLearningModuleDto
    {
        return $this->getScormLearningModuleService()
            ->getScormLearningModuleByRefId(
                $ref_id,
                $in_trash
            );
    }


    /**
     * @return ScormLearningModuleDto[]
     */
    public function getScormLearningModules(?bool $in_trash = null) : array
    {
        return $this->getScormLearningModuleService()
            ->getScormLearningModules(
                $in_trash
            );
    }


    public function getUnreadMailsCountById(int $id) : ?int
    {
        return $this->getUserMailService()
            ->getUnreadMailsCountById(
                $id
            );
    }


    public function getUnreadMailsCountByImportId(string $import_id) : ?int
    {
        return $this->getUserMailService()
            ->getUnreadMailsCountByImportId(
                $import_id
            );
    }


    public function getUserById(int $id) : ?UserDto
    {
        return $this->getUserService()
            ->getUserById(
                $id
            );
    }


    public function getUserByImportId(string $import_id) : ?UserDto
    {
        return $this->getUserService()
            ->getUserByImportId(
                $import_id
            );
    }


    /**
     * @return UserFavouriteDto[]
     */
    public function getUserFavourites(?int $user_id = null, ?string $user_import_id = null, ?int $object_id = null, ?string $object_import_id = null, ?int $object_ref_id = null) : array
    {
        return $this->getUserFavouriteService()
            ->getUserFavourites(
                $user_id,
                $user_import_id,
                $object_id,
                $object_import_id,
                $object_ref_id
            );
    }


    /**
     * @return UserRoleDto[]
     */
    public function getUserRoles(?int $user_id = null, ?string $user_import_id = null, ?int $role_id = null, ?string $role_import_id = null) : array
    {
        return $this->getUserRoleService()
            ->getUserRoles(
                $user_id,
                $user_import_id,
                $role_id,
                $role_import_id
            );
    }


    /**
     * @return UserDto[]
     */
    public function getUsers(
        ?string $external_account = null,
        ?string $login = null,
        ?string $email = null,
        ?string $matriculation_number = null,
        bool $access_limited_object_ids = false,
        bool $multi_fields = false,
        bool $preferences = false,
        bool $user_defined_fields = false
    ) : array {
        return $this->getUserService()
            ->getUsers(
                $external_account,
                $login,
                $email,
                $matriculation_number,
                $access_limited_object_ids,
                $multi_fields,
                $preferences,
                $user_defined_fields
            );
    }


    public function handleIliasEvent(string $component, string $event, array $parameters) : void
    {
        $user = $this->getCurrentApiUser();
        if ($user === null) {
            return;
        }

        $this->getChangeService()->handleIliasEvent(
            $user,
            $component,
            $event,
            $parameters
        );
    }


    public function handleIliasGoto() : void
    {
        $this->getProxyService()
            ->handleIliasGoto(
                $this->getIliasGlobalTemplate(),
                $this->getIliasLocator(),
                $this->getCurrentApiUser()
            );
    }


    public function handleIliasRedirect(string $url) : ?string
    {
        return $this->getProxyService()
            ->handleIliasRedirect(
                $url
            );
    }


    public function hasAccessByRefIdByUserId(int $ref_id, int $user_id, Permission $permission) : bool
    {
        return $this->getObjectService()
            ->hasAccessByRefIdByUserId(
                $ref_id,
                $user_id,
                $permission
            );
    }


    public function installHelperPlugin() : void
    {
        $this->getSetupService()
            ->installHelperPlugin();
    }


    public function isEnableRestApi() : bool
    {
        return $this->getRestConfigService()
            ->isEnableRestApi();
    }


    public function linkObjectByIdToId(int $id, int $parent_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByIdToId(
                $id,
                $parent_id
            );
    }


    public function linkObjectByIdToImportId(int $id, string $parent_import_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByIdToImportId(
                $id,
                $parent_import_id
            );
    }


    public function linkObjectByIdToRefId(int $id, int $parent_ref_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByIdToRefId(
                $id,
                $parent_ref_id
            );
    }


    public function linkObjectByImportIdToId(string $import_id, int $parent_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByImportIdToId(
                $import_id,
                $parent_id
            );
    }


    public function linkObjectByImportIdToImportId(string $import_id, string $parent_import_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByImportIdToImportId(
                $import_id,
                $parent_import_id
            );
    }


    public function linkObjectByImportIdToRefId(string $import_id, int $parent_ref_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByImportIdToRefId(
                $import_id,
                $parent_ref_id
            );
    }


    public function linkObjectByRefIdToId(int $ref_id, int $parent_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByRefIdToId(
                $ref_id,
                $parent_id
            );
    }


    public function linkObjectByRefIdToImportId(int $ref_id, string $parent_import_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByRefIdToImportId(
                $ref_id,
                $parent_import_id
            );
    }


    public function linkObjectByRefIdToRefId(int $ref_id, int $parent_ref_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->linkObjectByRefIdToRefId(
                $ref_id,
                $parent_ref_id
            );
    }


    public function moveObjectByIdToId(int $id, int $parent_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByIdToId(
                $id,
                $parent_id
            );
    }


    public function moveObjectByIdToImportId(int $id, string $parent_import_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByIdToImportId(
                $id,
                $parent_import_id
            );
    }


    public function moveObjectByIdToRefId(int $id, int $parent_ref_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByIdToRefId(
                $id,
                $parent_ref_id
            );
    }


    public function moveObjectByImportIdToId(string $import_id, int $parent_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByImportIdToId(
                $import_id,
                $parent_id
            );
    }


    public function moveObjectByImportIdToImportId(string $import_id, string $parent_import_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByImportIdToImportId(
                $import_id,
                $parent_import_id
            );
    }


    public function moveObjectByImportIdToRefId(string $import_id, int $parent_ref_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByImportIdToRefId(
                $import_id,
                $parent_ref_id
            );
    }


    public function moveObjectByRefIdToId(int $ref_id, int $parent_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByRefIdToId(
                $ref_id,
                $parent_id
            );
    }


    public function moveObjectByRefIdToImportId(int $ref_id, string $parent_import_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByRefIdToImportId(
                $ref_id,
                $parent_import_id
            );
    }


    public function moveObjectByRefIdToRefId(int $ref_id, int $parent_ref_id) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->moveObjectByRefIdToRefId(
                $ref_id,
                $parent_ref_id
            );
    }


    public function purgeChanges() : void
    {
        $this->getChangeService()
            ->purgeChanges();
    }


    public function removeCourseMemberByIdByUserId(int $id, int $user_id) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->removeCourseMemberByIdByUserId(
                $id,
                $user_id
            );
    }


    public function removeCourseMemberByIdByUserImportId(int $id, string $user_import_id) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->removeCourseMemberByIdByUserImportId(
                $id,
                $user_import_id
            );
    }


    public function removeCourseMemberByImportIdByUserId(string $import_id, int $user_id) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->removeCourseMemberByImportIdByUserId(
                $import_id,
                $user_id
            );
    }


    public function removeCourseMemberByImportIdByUserImportId(string $import_id, string $user_import_id) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->removeCourseMemberByImportIdByUserImportId(
                $import_id,
                $user_import_id
            );
    }


    public function removeCourseMemberByRefIdByUserId(int $ref_id, int $user_id) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->removeCourseMemberByRefIdByUserId(
                $ref_id,
                $user_id
            );
    }


    public function removeCourseMemberByRefIdByUserImportId(int $ref_id, string $user_import_id) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->removeCourseMemberByRefIdByUserImportId(
                $ref_id,
                $user_import_id
            );
    }


    public function removeGroupMemberByIdByUserId(int $id, int $user_id) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->removeGroupMemberByIdByUserId(
                $id,
                $user_id
            );
    }


    public function removeGroupMemberByIdByUserImportId(int $id, string $user_import_id) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->removeGroupMemberByIdByUserImportId(
                $id,
                $user_import_id
            );
    }


    public function removeGroupMemberByImportIdByUserId(string $import_id, int $user_id) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->removeGroupMemberByImportIdByUserId(
                $import_id,
                $user_id
            );
    }


    public function removeGroupMemberByImportIdByUserImportId(string $import_id, string $user_import_id) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->removeGroupMemberByImportIdByUserImportId(
                $import_id,
                $user_import_id
            );
    }


    public function removeGroupMemberByRefIdByUserId(int $ref_id, int $user_id) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->removeGroupMemberByRefIdByUserId(
                $ref_id,
                $user_id
            );
    }


    public function removeGroupMemberByRefIdByUserImportId(int $ref_id, string $user_import_id) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->removeGroupMemberByRefIdByUserImportId(
                $ref_id,
                $user_import_id
            );
    }


    public function removeOrganisationalUnitStaffByExternalIdByUserId(string $external_id, int $user_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->removeOrganisationalUnitStaffByExternalIdByUserId(
                $external_id,
                $user_id,
                $position_id
            );
    }


    public function removeOrganisationalUnitStaffByExternalIdByUserImportId(string $external_id, string $user_import_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->removeOrganisationalUnitStaffByExternalIdByUserImportId(
                $external_id,
                $user_import_id,
                $position_id
            );
    }


    public function removeOrganisationalUnitStaffByIdByUserId(int $id, int $user_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->removeOrganisationalUnitStaffByIdByUserId(
                $id,
                $user_id,
                $position_id
            );
    }


    public function removeOrganisationalUnitStaffByIdByUserImportId(int $id, string $user_import_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->removeOrganisationalUnitStaffByIdByUserImportId(
                $id,
                $user_import_id,
                $position_id
            );
    }


    public function removeOrganisationalUnitStaffByRefIdByUserId(int $ref_id, int $user_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->removeOrganisationalUnitStaffByRefIdByUserId(
                $ref_id,
                $user_id,
                $position_id
            );
    }


    public function removeOrganisationalUnitStaffByRefIdByUserImportId(int $ref_id, string $user_import_id, int $position_id) : ?OrganisationalUnitStaffDto
    {
        return $this->getOrganisationalUnitStaffService()
            ->removeOrganisationalUnitStaffByRefIdByUserImportId(
                $ref_id,
                $user_import_id,
                $position_id
            );
    }


    public function removeUserFavouriteByIdByObjectId(int $id, int $object_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->removeUserFavouriteByIdByObjectId(
                $id,
                $object_id
            );
    }


    public function removeUserFavouriteByIdByObjectImportId(int $id, string $object_import_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->removeUserFavouriteByIdByObjectImportId(
                $id,
                $object_import_id
            );
    }


    public function removeUserFavouriteByIdByObjectRefId(int $id, int $object_ref_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->removeUserFavouriteByIdByObjectRefId(
                $id,
                $object_ref_id
            );
    }


    public function removeUserFavouriteByImportIdByObjectId(string $import_id, int $object_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->removeUserFavouriteByImportIdByObjectId(
                $import_id,
                $object_id
            );
    }


    public function removeUserFavouriteByImportIdByObjectImportId(string $import_id, string $object_import_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->removeUserFavouriteByImportIdByObjectImportId(
                $import_id,
                $object_import_id
            );
    }


    public function removeUserFavouriteByImportIdByObjectRefId(string $import_id, int $object_ref_id) : ?UserFavouriteDto
    {
        return $this->getUserFavouriteService()
            ->removeUserFavouriteByImportIdByObjectRefId(
                $import_id,
                $object_ref_id
            );
    }


    public function removeUserRoleByIdByRoleId(int $id, int $role_id) : ?UserRoleDto
    {
        return $this->getUserRoleService()
            ->removeUserRoleByIdByRoleId(
                $id,
                $role_id
            );
    }


    public function removeUserRoleByIdByRoleImportId(int $id, string $role_import_id) : ?UserRoleDto
    {
        return $this->getUserRoleService()
            ->removeUserRoleByIdByRoleImportId(
                $id,
                $role_import_id
            );
    }


    public function removeUserRoleByImportIdByRoleId(string $import_id, int $role_id) : ?UserRoleDto
    {
        return $this->getUserRoleService()
            ->removeUserRoleByImportIdByRoleId(
                $import_id,
                $role_id
            );
    }


    public function removeUserRoleByImportIdByRoleImportId(string $import_id, string $role_import_id) : ?UserRoleDto
    {
        return $this->getUserRoleService()
            ->removeUserRoleByImportIdByRoleImportId(
                $import_id,
                $role_import_id
            );
    }


    public function transferChanges() : void
    {
        $this->getChangeService()
            ->transferChanges();
    }


    public function uninstallHelperPlugin() : void
    {
        $this->getSetupService()
            ->uninstallHelperPlugin();
    }


    public function updateAvatarById(int $id, ?string $file) : ?UserIdDto
    {
        return $this->getUserService()
            ->updateAvatarById(
                $id,
                $file
            );
    }


    public function updateAvatarByImportId(string $import_id, ?string $file) : ?UserIdDto
    {
        return $this->getUserService()
            ->updateAvatarByImportId(
                $import_id,
                $file
            );
    }


    public function updateCategoryById(int $id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCategoryService()
            ->updateCategoryById(
                $id,
                $diff
            );
    }


    public function updateCategoryByImportId(string $import_id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCategoryService()
            ->updateCategoryByImportId(
                $import_id,
                $diff
            );
    }


    public function updateCategoryByRefId(int $ref_id, CategoryDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCategoryService()
            ->updateCategoryByRefId(
                $ref_id,
                $diff
            );
    }


    public function updateCourseById(int $id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCourseService()
            ->updateCourseById(
                $id,
                $diff
            );
    }


    public function updateCourseByImportId(string $import_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCourseService()
            ->updateCourseByImportId(
                $import_id,
                $diff
            );
    }


    public function updateCourseByRefId(int $ref_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getCourseService()
            ->updateCourseByRefId(
                $ref_id,
                $diff
            );
    }


    public function updateCourseMemberByIdByUserId(int $id, int $user_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->updateCourseMemberByIdByUserId(
                $id,
                $user_id,
                $diff
            );
    }


    public function updateCourseMemberByIdByUserImportId(int $id, string $user_import_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->updateCourseMemberByIdByUserImportId(
                $id,
                $user_import_id,
                $diff
            );
    }


    public function updateCourseMemberByImportIdByUserId(string $import_id, int $user_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->updateCourseMemberByImportIdByUserId(
                $import_id,
                $user_id,
                $diff
            );
    }


    public function updateCourseMemberByImportIdByUserImportId(string $import_id, string $user_import_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->updateCourseMemberByImportIdByUserImportId(
                $import_id,
                $user_import_id,
                $diff
            );
    }


    public function updateCourseMemberByRefIdByUserId(int $ref_id, int $user_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->updateCourseMemberByRefIdByUserId(
                $ref_id,
                $user_id,
                $diff
            );
    }


    public function updateCourseMemberByRefIdByUserImportId(int $ref_id, string $user_import_id, CourseMemberDiffDto $diff) : ?CourseMemberIdDto
    {
        return $this->getCourseMemberService()
            ->updateCourseMemberByRefIdByUserImportId(
                $ref_id,
                $user_import_id,
                $diff
            );
    }


    public function updateFileById(int $id, FileDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->updateFileById(
                $id,
                $diff
            );
    }


    public function updateFileByImportId(string $import_id, FileDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->updateFileByImportId(
                $import_id,
                $diff
            );
    }


    public function updateFileByRefId(int $ref_id, FileDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->updateFileByRefId(
                $ref_id,
                $diff
            );
    }


    public function updateFluxIliasRestObjectById(int $id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFluxIliasRestObjectService()
            ->updateFluxIliasRestObjectById(
                $id,
                $diff
            );
    }


    public function updateFluxIliasRestObjectByImportId(string $import_id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFluxIliasRestObjectService()
            ->updateFluxIliasRestObjectByImportId(
                $import_id,
                $diff
            );
    }


    public function updateFluxIliasRestObjectByRefId(int $ref_id, FluxIliasRestObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getFluxIliasRestObjectService()
            ->updateFluxIliasRestObjectByRefId(
                $ref_id,
                $diff
            );
    }


    public function updateGroupById(int $id, GroupDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getGroupService()
            ->updateGroupById(
                $id,
                $diff
            );
    }


    public function updateGroupByImportId(string $import_id, GroupDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getGroupService()
            ->updateGroupByImportId(
                $import_id,
                $diff
            );
    }


    public function updateGroupByRefId(int $ref_id, GroupDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getGroupService()
            ->updateGroupByRefId(
                $ref_id,
                $diff
            );
    }


    public function updateGroupMemberByIdByUserId(int $id, int $user_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->updateGroupMemberByIdByUserId(
                $id,
                $user_id,
                $diff
            );
    }


    public function updateGroupMemberByIdByUserImportId(int $id, string $user_import_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->updateGroupMemberByIdByUserImportId(
                $id,
                $user_import_id,
                $diff
            );
    }


    public function updateGroupMemberByImportIdByUserId(string $import_id, int $user_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->updateGroupMemberByImportIdByUserId(
                $import_id,
                $user_id,
                $diff
            );
    }


    public function updateGroupMemberByImportIdByUserImportId(string $import_id, string $user_import_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->updateGroupMemberByImportIdByUserImportId(
                $import_id,
                $user_import_id,
                $diff
            );
    }


    public function updateGroupMemberByRefIdByUserId(int $ref_id, int $user_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->updateGroupMemberByRefIdByUserId(
                $ref_id,
                $user_id,
                $diff
            );
    }


    public function updateGroupMemberByRefIdByUserImportId(int $ref_id, string $user_import_id, GroupMemberDiffDto $diff) : ?GroupMemberIdDto
    {
        return $this->getGroupMemberService()
            ->updateGroupMemberByRefIdByUserImportId(
                $ref_id,
                $user_import_id,
                $diff
            );
    }


    public function updateObjectById(int $id, ObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->updateObjectById(
                $id,
                $diff
            );
    }


    public function updateObjectByImportId(string $import_id, ObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->updateObjectByImportId(
                $import_id,
                $diff
            );
    }


    public function updateObjectByRefId(int $ref_id, ObjectDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getObjectService()
            ->updateObjectByRefId(
                $ref_id,
                $diff
            );
    }


    public function updateObjectLearningProgressByIdByUserId(int $id, int $user_id, ObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->getObjectLearningProgressService()
            ->updateObjectLearningProgressByIdByUserId(
                $id,
                $user_id,
                $learning_progress
            );
    }


    public function updateObjectLearningProgressByIdByUserImportId(int $id, string $user_import_id, ObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->getObjectLearningProgressService()
            ->updateObjectLearningProgressByIdByUserImportId(
                $id,
                $user_import_id,
                $learning_progress
            );
    }


    public function updateObjectLearningProgressByImportIdByUserId(string $import_id, int $user_id, ObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->getObjectLearningProgressService()
            ->updateObjectLearningProgressByImportIdByUserId(
                $import_id,
                $user_id,
                $learning_progress
            );
    }


    public function updateObjectLearningProgressByImportIdByUserImportId(string $import_id, string $user_import_id, ObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->getObjectLearningProgressService()
            ->updateObjectLearningProgressByImportIdByUserImportId(
                $import_id,
                $user_import_id,
                $learning_progress
            );
    }


    public function updateObjectLearningProgressByRefIdByUserId(int $ref_id, int $user_id, ObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->getObjectLearningProgressService()
            ->updateObjectLearningProgressByRefIdByUserId(
                $ref_id,
                $user_id,
                $learning_progress
            );
    }


    public function updateObjectLearningProgressByRefIdByUserImportId(int $ref_id, string $user_import_id, ObjectLearningProgress $learning_progress) : ?ObjectLearningProgressIdDto
    {
        return $this->getObjectLearningProgressService()
            ->updateObjectLearningProgressByRefIdByUserImportId(
                $ref_id,
                $user_import_id,
                $learning_progress
            );
    }


    public function updateOrganisationalUnitByExternalId(string $external_id, OrganisationalUnitDiffDto $diff) : ?OrganisationalUnitIdDto
    {
        return $this->getOrganisationalUnitService()
            ->updateOrganisationalUnitByExternalId(
                $external_id,
                $diff
            );
    }


    public function updateOrganisationalUnitById(int $id, OrganisationalUnitDiffDto $diff) : ?OrganisationalUnitIdDto
    {
        return $this->getOrganisationalUnitService()
            ->updateOrganisationalUnitById(
                $id,
                $diff
            );
    }


    public function updateOrganisationalUnitByRefId(int $ref_id, OrganisationalUnitDiffDto $diff) : ?OrganisationalUnitIdDto
    {
        return $this->getOrganisationalUnitService()
            ->updateOrganisationalUnitByRefId(
                $ref_id,
                $diff
            );
    }


    public function updateOrganisationalUnitPositionById(int $id, OrganisationalUnitPositionDiffDto $diff) : ?OrganisationalUnitPositionIdDto
    {
        return $this->getOrganisationalUnitPositionService()
            ->updateOrganisationalUnitPositionById(
                $id,
                $diff
            );
    }


    public function updateRoleById(int $id, RoleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getRoleService()
            ->updateRoleById(
                $id,
                $diff
            );
    }


    public function updateRoleByImportId(string $import_id, RoleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getRoleService()
            ->updateRoleByImportId(
                $import_id,
                $diff
            );
    }


    public function updateScormLearningModuleById(int $id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->updateScormLearningModuleById(
                $id,
                $diff
            );
    }


    public function updateScormLearningModuleByImportId(string $import_id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->updateScormLearningModuleByImportId(
                $import_id,
                $diff
            );
    }


    public function updateScormLearningModuleByRefId(int $ref_id, ScormLearningModuleDiffDto $diff) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->updateScormLearningModuleByRefId(
                $ref_id,
                $diff
            );
    }


    public function updateUserById(int $id, UserDiffDto $diff) : ?UserIdDto
    {
        return $this->getUserService()
            ->updateUserById(
                $id,
                $diff
            );
    }


    public function updateUserByImportId(string $import_id, UserDiffDto $diff) : ?UserIdDto
    {
        return $this->getUserService()
            ->updateUserByImportId(
                $import_id,
                $diff
            );
    }


    public function uploadFileById(int $id, ?string $title = null, bool $replace = false) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->uploadFileById(
                $id,
                $title,
                $replace
            );
    }


    public function uploadFileByImportId(string $import_id, ?string $title = null, bool $replace = false) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->uploadFileByImportId(
                $import_id,
                $title,
                $replace
            );
    }


    public function uploadFileByRefId(int $ref_id, ?string $title = null, bool $replace = false) : ?ObjectIdDto
    {
        return $this->getFileService()
            ->uploadFileByRefId(
                $ref_id,
                $title,
                $replace
            );
    }


    public function uploadScormLearningModuleById(int $id, string $file) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->uploadScormLearningModuleById(
                $id,
                $file
            );
    }


    public function uploadScormLearningModuleByImportId(string $import_id, string $file) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->uploadScormLearningModuleByImportId(
                $import_id,
                $file
            );
    }


    public function uploadScormLearningModuleByRefId(int $ref_id, string $file) : ?ObjectIdDto
    {
        return $this->getScormLearningModuleService()
            ->uploadScormLearningModuleByRefId(
                $ref_id,
                $file
            );
    }


    private function getCategoryService() : CategoryService
    {
        return CategoryService::new(
            $this->getIliasDatabase(),
            $this->getObjectService()
        );
    }


    private function getChangeService() : ChangeService
    {
        return ChangeService::new(
            $this->getIliasDatabase(),
            $this->getConfigService(),
            $this->getCategoryService(),
            $this->getCourseService(),
            $this->getCourseMemberService(),
            $this->getFileService(),
            $this->getFluxIliasRestObjectService(),
            $this->getGroupService(),
            $this->getGroupMemberService(),
            $this->getObjectService(),
            $this->getObjectLearningProgressService(),
            $this->getOrganisationalUnitService(),
            $this->getOrganisationalUnitStaffService(),
            $this->getRoleService(),
            $this->getScormLearningModuleService(),
            $this->getUserService(),
            $this->getUserRoleService(),
            $this->getRestApi(),
            $this->getCronConfigService()
        );
    }


    private function getConfigFormService() : ConfigFormService
    {
        return ConfigFormService::new(
            $this->getChangeService(),
            $this->getFluxIliasRestObjectService(),
            $this->getProxyConfigService(),
            $this->getRestConfigService(),
            $this->getIliasDic()
        );
    }


    private function getConfigService() : ConfigService
    {
        return ConfigService::new();
    }


    private function getCourseMemberService() : CourseMemberService
    {
        return CourseMemberService::new(
            $this->getIliasDatabase(),
            $this->getCourseService(),
            $this->getUserService()
        );
    }


    private function getCourseService() : CourseService
    {
        return CourseService::new(
            $this->getIliasDatabase(),
            $this->getObjectService()
        );
    }


    private function getCronConfigService() : CronConfigService
    {
        return CronConfigService::new(
            $this->getIliasCronWrapper(),
            $this->getIliasUser()
        );
    }


    private function getCronService() : CronService
    {
        return CronService::new(
            $this->getIliasDatabase(),
            $this->getChangeService()
        );
    }


    private function getFileService() : FileService
    {
        return FileService::new(
            $this->getIliasDatabase(),
            $this->getIliasUpload(),
            $this->getObjectService()
        );
    }


    private function getFluxIliasRestObjectService() : FluxIliasRestObjectService
    {
        return FluxIliasRestObjectService::new(
            $this->getConfigService(),
            $this->getObjectService(),
            $this->getObjectConfigService(),
            $this->getIliasDatabase()
        );
    }


    private function getGroupMemberService() : GroupMemberService
    {
        return GroupMemberService::new(
            $this->getIliasDatabase(),
            $this->getGroupService(),
            $this->getUserService()
        );
    }


    private function getGroupService() : GroupService
    {
        return GroupService::new(
            $this->getIliasDatabase(),
            $this->getObjectService()
        );
    }


    private function getIliasAccess() : ilAccessHandler
    {
        return $this->getIliasDic()->access();
    }


    private function getIliasCron() : ilCronServices
    {
        return $this->getIliasDic()->cron();
    }


    private function getIliasCronWrapper() : IliasCronWrapper
    {
        if (method_exists($this->getIliasDic(), "cron")) {
            return NewIliasCronWrapper::new(
                $this->getIliasCron()
            );
        } else {
            return LegacyIliasCronWrapper::new();
        }
    }


    private function getIliasDatabase() : ilDBInterface
    {
        return $this->getIliasDic()->database();
    }


    private function getIliasDic() : Container
    {
        global $DIC;

        return $DIC;
    }


    private function getIliasFavourite() : ilFavouritesDBRepository
    {
        return new ilFavouritesDBRepository();
    }


    private function getIliasGlobalTemplate() : ilGlobalTemplateInterface
    {
        return $this->getIliasDic()->ui()->mainTemplate();
    }


    private function getIliasLocator() : ilLocatorGUI
    {
        return $this->getIliasDic()["ilLocator"];
    }


    private function getIliasObjectDefinition() : ilObjectDefinition
    {
        return $this->getIliasDic()["objDefinition"];
    }


    private function getIliasRbac() : RBACServices
    {
        return $this->getIliasDic()->rbac();
    }


    private function getIliasTree() : ilTree
    {
        return $this->getIliasDic()->repositoryTree();
    }


    private function getIliasUpload() : FileUpload
    {
        return $this->getIliasDic()->upload();
    }


    private function getIliasUser() : ilObjUser
    {
        return $this->getIliasDic()->user();
    }


    private function getMenuService() : MenuService
    {
        return MenuService::new(
            $this->getIliasDic(),
            $this->getConfigFormService(),
            $this->getProxyService()
        );
    }


    private function getObjectConfigService() : ObjectConfigService
    {
        return ObjectConfigService::new(
            $this->getIliasDatabase()
        );
    }


    private function getObjectLearningProgressService() : ObjectLearningProgressService
    {
        return ObjectLearningProgressService::new(
            $this->getIliasDatabase(),
            $this->getObjectService(),
            $this->getUserService()
        );
    }


    private function getObjectService() : ObjectService
    {
        return ObjectService::new(
            $this->getIliasDatabase(),
            $this->getIliasTree(),
            $this->getIliasUser(),
            $this->getIliasObjectDefinition(),
            $this->getIliasAccess()
        );
    }


    private function getOrganisationalUnitPositionService() : OrganisationalUnitPositionService
    {
        return OrganisationalUnitPositionService::new(
            $this->getIliasDatabase()
        );
    }


    private function getOrganisationalUnitService() : OrganisationalUnitService
    {
        return OrganisationalUnitService::new(
            $this->getIliasDatabase()
        );
    }


    private function getOrganisationalUnitStaffService() : OrganisationalUnitStaffService
    {
        return OrganisationalUnitStaffService::new(
            $this->getIliasDatabase(),
            $this->getOrganisationalUnitService(),
            $this->getUserService(),
            $this->getOrganisationalUnitPositionService()
        );
    }


    private function getProxyConfigService() : ProxyConfigService
    {
        return ProxyConfigService::new(
            $this->getConfigService()
        );
    }


    private function getProxyService() : ProxyService
    {
        return ProxyService::new(
            $this->getRestApi(),
            $this->getConfigFormService(),
            $this->getProxyConfigService(),
            $this->getFluxIliasRestObjectService(),
            $this->getIliasDic()
        );
    }


    private function getRestApi() : RestApi
    {
        return RestApi::new();
    }


    private function getRestConfigService() : RestConfigService
    {
        return RestConfigService::new(
            $this->getConfigService()
        );
    }


    private function getRoleService() : RoleService
    {
        return RoleService::new(
            $this->getIliasDatabase(),
            $this->getObjectService(),
            $this->getIliasRbac()
        );
    }


    private function getScormLearningModuleService() : ScormLearningModuleService
    {
        return ScormLearningModuleService::new(
            $this->getIliasDatabase(),
            $this->getObjectService()
        );
    }


    private function getSetupService() : SetupService
    {
        return SetupService::new(
            $this->getChangeService(),
            $this->getConfigService(),
            $this->getCronService(),
            $this->getObjectConfigService()
        );
    }


    private function getUserFavouriteService() : UserFavouriteService
    {
        return UserFavouriteService::new(
            $this->getIliasDatabase(),
            $this->getUserService(),
            $this->getObjectService(),
            $this->getIliasFavourite()
        );
    }


    private function getUserMailService() : UserMailService
    {
        return UserMailService::new(
            $this->getIliasDatabase(),
            $this->getUserService()
        );
    }


    private function getUserRoleService() : UserRoleService
    {
        return UserRoleService::new(
            $this->getIliasDatabase(),
            $this->getUserService(),
            $this->getRoleService(),
            $this->getIliasRbac()
        );
    }


    private function getUserService() : UserService
    {
        return UserService::new(
            $this->getIliasDatabase(),
            $this->getIliasRbac(),
            $this->getObjectService()
        );
    }
}
