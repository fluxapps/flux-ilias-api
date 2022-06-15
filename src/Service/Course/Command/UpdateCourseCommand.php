<?php

namespace FluxIliasApi\Service\Course\Command;

use FluxIliasApi\Adapter\Course\CourseDiffDto;
use FluxIliasApi\Adapter\Course\CourseDto;
use FluxIliasApi\Adapter\Object\ObjectIdDto;
use FluxIliasApi\Service\Course\CourseQuery;
use FluxIliasApi\Service\Course\Port\CourseService;
use FluxIliasApi\Service\CustomMetadata\CustomMetadataQuery;
use ilDBInterface;

class UpdateCourseCommand
{

    use CourseQuery;
    use CustomMetadataQuery;

    private CourseService $course_service;
    private ilDBInterface $ilias_database;


    private function __construct(
        /*private readonly*/ CourseService $course_service,
        /*private readonly*/ ilDBInterface $ilias_database
    ) {
        $this->course_service = $course_service;
        $this->ilias_database = $ilias_database;
    }


    public static function new(
        CourseService $course_service,
        ilDBInterface $ilias_database
    ) : static {
        return new static(
            $course_service,
            $ilias_database
        );
    }


    public function updateCourseById(int $id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->updateCourse(
            $this->course_service->getCourseById(
                $id,
                false
            ),
            $diff
        );
    }


    public function updateCourseByImportId(string $import_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->updateCourse(
            $this->course_service->getCourseByImportId(
                $import_id,
                false
            ),
            $diff
        );
    }


    public function updateCourseByRefId(int $ref_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->updateCourse(
            $this->course_service->getCourseByRefId(
                $ref_id,
                false
            ),
            $diff
        );
    }


    private function updateCourse(?CourseDto $course, CourseDiffDto $diff) : ?ObjectIdDto
    {
        if ($course === null) {
            return null;
        }

        $ilias_course = $this->getIliasCourse(
            $course->id,
            $course->ref_id
        );
        if ($ilias_course === null) {
            return null;
        }

        $this->mapCourseDiff(
            $diff,
            $ilias_course
        );

        $ilias_course->update();

        return ObjectIdDto::new(
            $course->id,
            $diff->import_id ?? $course->import_id,
            $course->ref_id
        );
    }
}
