<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\LicenseAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;
use PhpSpec\ObjectBehavior;

class LicenseAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LicenseAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_can_format_the_tag_with_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['http://opensource.org/licenses/gpl-license.php GNU Public License'], $context)
            ->shouldBe(['url' => 'http://opensource.org/licenses/gpl-license.php', 'name' => 'GNU Public License']);
    }

    function it_can_format_the_tag_without_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['GPL'], $context)
            ->shouldBe(['name' => 'GPL']);
    }
}
