<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Special characters enum
 *
 * @package   Enum
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class SpecialCharsEnum extends Enum
{
    /** @var static $SLASH */
    public static $SLASH = '/';

    /** @var static $AMPERSAND */
    public static $AMPERSAND = '&';

    /** @var static $QUESTION_MARK */
    public static $QUESTION_MARK = '?';

    /** @var static $UNDERLINE */
    public static $UNDERLINE = '_';

    /** @var static $EOL */
    public static $EOL = "\n";

    /** @var static $TAB */
    public static $TAB = "\t";

    /** @var static $MINUS */
    public static $MINUS = "-";

    /** @var static $NBSP */
    public static $NBSP = '&nbsp;';

    /** @var static $DOT */
    public static $DOT = '.';

    /**
     * Get &nbsp; encoded in UTF-8
     *
     * @return string
     */
    public static function getUtf8Nbsp(): string
    {
        return chr( 194 ) . chr( 160 );
    }
}

SpecialCharsEnum::construct();