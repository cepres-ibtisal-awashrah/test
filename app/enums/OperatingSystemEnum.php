<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php

use Enum\Enum;

require_once SYSPATH . '/libraries/Enum/Enum' . EXT;

/**
 * Operating system enum
 *
 * @package   Enum
 * @author    Sebastian Karpeta <sebastian@assembla.com>
 * @copyright Copyright 2003-2021 Gurock Software GmbH. All rights reserved.
 */
class OperatingSystemEnum extends Enum
{
    /** @var static $X86_64 */
    public static $X86_64 = 'x86_64';

    /** @var static $X32 */
    public static $X32 = 'x32';

    /** @var static $WINDOWS */
    public static $WINDOWS = 'windows';

    /** @var static $DOTEXE */
    public static $DOTEXE = '.exe';    
}

OperatingSystemEnum::construct();
