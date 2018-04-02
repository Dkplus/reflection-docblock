<?php
declare(strict_types=1);

namespace Dkplus\Reflection\DocBlock;

use phpDocumentor\Reflection\Types\Context;

interface MultiTagAttributeFormatter
{
    public function format(string $tag, array $attributes, Context $context): array;
}
