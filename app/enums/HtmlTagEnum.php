<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Html tag code enum.
 *
 * @package Enum
 * @author  Piotr Milcarz <piotr.milcarz@gurock.io>
 */
class HtmlTagEnum extends Enum
{
    /** @var string $LI */
    public static $LI = '<li>';

    /**
     * Get close LI tag
     *
     * @return string
     */
    public static function getCloseLiTag(): string
    {
        return static::getCloseTag(static::$LI);
    }

    /**
     * Get closing version of given tag
     *
     * @param HtmlTagEnum $tag
     * 
     * @return string
     */
    private static function getCloseTag(HtmlTagEnum $tag): string
    {
        return str_replace(
            '<',
            '</',
            $tag->value
        );
    }
}

HtmlTagEnum::construct();
