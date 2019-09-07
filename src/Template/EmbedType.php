<?php

namespace Helpers\Template;

use MyCLabs\Enum\Enum;

/**
 * @method static EmbedType CSS()
 * @method static EmbedType JS()
 */
class EmbedType extends Enum
{
    private const CSS = "CSS";
    private const JS = "JS";
}