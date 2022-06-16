<?php

namespace FluxIliasApi\Adapter\GroupMember;

use FluxIliasApi\Adapter\ObjectLearningProgress\LegacyObjectLearningProgress;

class GroupMemberDiffDto
{

    private function __construct(
        public readonly ?bool $member_role,
        public readonly ?bool $administrator_role,
        public readonly ?LegacyObjectLearningProgress $learning_progress,
        public readonly ?bool $tutorial_support,
        public readonly ?bool $notification
    ) {

    }


    public static function new(
        ?bool $member_role = null,
        ?bool $administrator_role = null,
        ?LegacyObjectLearningProgress $learning_progress = null,
        ?bool $tutorial_support = null,
        ?bool $notification = null
    ) : static {
        return new static(
            $member_role,
            $administrator_role,
            $learning_progress,
            $tutorial_support,
            $notification
        );
    }


    public static function newFromObject(
        object $diff
    ) : static {
        return static::new(
            $diff->member_role ?? null,
            $diff->administrator_role ?? null,
            ($learning_progress = $diff->learning_progress ?? null) !== null ? LegacyObjectLearningProgress::from($learning_progress) : null,
            $diff->tutorial_support ?? null,
            $diff->notification ?? null
        );
    }
}
