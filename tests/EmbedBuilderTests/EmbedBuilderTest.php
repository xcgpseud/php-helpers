<?php

namespace Tests\EmbedBuilderTests;

use Helpers\Template\EmbedBuilder;
use Helpers\Template\EmbedType;
use PHPUnit\Framework\TestCase;

class EmbedBuilderTest extends TestCase
{
    public function testCssWithKeyValues(): void
    {
        $expectedOutput = '<link rel="stylesheet" type="text/css" href="style.css"/>';
        $css = EmbedBuilder::start(EmbedType::CSS())
            ->rel("stylesheet")
            ->type("text/css")
            ->href("style.css")
            ->getString();

        $this->assertEquals($expectedOutput, $css);
    }

    public function testJsWithKeyValues(): void
    {
        $expectedOutput = '<script src="script.js"></script>';
        $js = EmbedBuilder::start(EmbedType::JS())
            ->src("script.js")
            ->getString();

        $this->assertEquals($expectedOutput, $js);
    }

    public function testCssWithMixed(): void
    {
        $expectedOutput = '<link rel="stylesheet" hidden/>';
        $css = EmbedBuilder::start(EmbedType::CSS())
            ->rel("stylesheet")
            ->hidden()
            ->getString();

        $this->assertEquals($expectedOutput, $css);
    }

    public function testJsWithMixed(): void
    {
        $expectedOutput = '<script src="script.js" async></script>';
        $js = EmbedBuilder::start(EmbedType::JS())
            ->src("script.js")
            ->async()
            ->getString();

        $this->assertEquals($expectedOutput, $js);
    }
}