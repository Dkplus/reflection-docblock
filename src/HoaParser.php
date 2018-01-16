<?php
declare(strict_types=1);

namespace Dkplus\Reflection\DocBlock;

use Hoa\Compiler\Llk\Llk;
use Hoa\Compiler\Llk\Parser;
use Hoa\File\Read;
use Hoa\Visitor\Visit;

/** @internal */
class HoaParser
{
    /** @var Parser */
    private $parser;


    /**
     * @throws \Hoa\Compiler\Exception\Exception
     * @throws \Hoa\Compiler\Exception\UnexpectedToken
     */
    public function parseDockBlock(string $dockBlock, Visit $visitor): DocBlockReflection
    {
        $parser = $this->loadParser();
        $ast = $parser->parse($dockBlock);
        return $visitor->visit($ast);
    }

    /** @throws \Hoa\Compiler\Exception\Exception */
    private function loadParser(): Parser
    {
        if ($this->parser !== null) {
            return $this->parser;
        }
        $file = new Read(__DIR__ . '/../resources/doc_block_grammar.pp');
        $parser = Llk::load($file);
        return $this->parser = $parser;
    }
}
