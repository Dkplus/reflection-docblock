<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock;

use Countable;
use Dkplus\Reflection\DocBlock\AnnotationReflection;
use Dkplus\Reflection\DocBlock\Annotations;
use Dkplus\Reflection\DocBlock\Exception\MissingAnnotation;
use PhpSpec\ObjectBehavior;

/**
 * @method shouldIterateAs(iterable $expected)
 */
class AnnotationsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Annotations::class);
    }

    function it_is_countable()
    {
        $reflection = AnnotationReflection::unqualified('internal', []);
        $this->beConstructedWith($reflection);
        $this->shouldImplement(Countable::class);
        $this->shouldHaveCount(1);
    }

    function it_is_iterable()
    {
        $internal = AnnotationReflection::unqualified('internal', []);
        $ignore = AnnotationReflection::unqualified('ignore', []);
        $this->beConstructedWith($internal, $ignore);
        $this->shouldIterateAs([$internal, $ignore]);
    }

    function it_maps_over_the_annotations()
    {
        $internal = AnnotationReflection::unqualified('internal', []);
        $this->beConstructedWith($internal);
        $this->map('get_class')->shouldBe([AnnotationReflection::class]);
    }

    function it_filters_the_annotations()
    {
        $internal = AnnotationReflection::unqualified('internal', []);
        $ignore = AnnotationReflection::unqualified('ignore', []);
        $this->beConstructedWith($internal, $ignore);

        $this->filter(function (AnnotationReflection $reflection) {
            return $reflection->tag() !== 'internal';
        })->shouldBeLike(new Annotations($ignore));
    }

    function it_has_a_shortcut_to_filter_the_annotations_by_tag_name()
    {
        $internal = AnnotationReflection::unqualified('internal', []);
        $ignore = AnnotationReflection::unqualified('ignore', []);
        $this->beConstructedWith($internal, $ignore);

        $this->withTag('ignore')->shouldBeLike(new Annotations($ignore));
    }

    function it_merges_other_collections()
    {
        $this->beConstructedWith(
            AnnotationReflection::unqualified('internal', []),
            AnnotationReflection::unqualified('deprecated', [])
        );
        $this->merge(new Annotations(
            AnnotationReflection::unqualified('ignore', []),
            AnnotationReflection::unqualified('internal', [])
        ), new Annotations(
            AnnotationReflection::unqualified('ignore', []),
            AnnotationReflection::unqualified('source', [])
        ))->shouldBeLike(new Annotations(
            AnnotationReflection::unqualified('internal', []),
            AnnotationReflection::unqualified('deprecated', []),
            AnnotationReflection::unqualified('ignore', []),
            AnnotationReflection::unqualified('source', [])
        ));
    }

    function it_can_include_all_attached_annotations()
    {
        $attached = AnnotationReflection::unqualified('internal', []);
        $annotation = AnnotationReflection::fullyQualified('My\\Annotation', [], $attached);
        $this->beConstructedWith($annotation);
        $this->includeAttached()->shouldBeLike(new Annotations($annotation, $attached));
    }

    function it_knows_whether_it_contains_at_least_one_annotation_with_a_given_tag_name()
    {
        $this->beConstructedWith(AnnotationReflection::unqualified('internal', []));
        $this->containsAtLeastOneWithTag('internal')->shouldBe(true);
        $this->containsAtLeastOneWithTag('ignore')->shouldBe(false);
    }

    function it_provides_one_annotation_of_a_given_tag_if_asks_for_this()
    {
        $internal = AnnotationReflection::unqualified('internal', []);
        $this->beConstructedWith($internal);
        $this->oneWithTag('internal')->shouldBe($internal);
        $this->shouldThrow(MissingAnnotation::class)->during('oneWithTag', ['ignore']);
    }
}
