<?php
/**
 * @package      Prism
 * @subpackage   Version
 * @author       FunFex <opensource@funfex.com>
 * @copyright    Copyright (C) 2020 FunFex LTD. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Library\Prism;

/**
 * Prism Library version information
 *
 * @package      Prism
 * @subpackage   Version
 */
class Version
{
    /**
     * Extension name
     *
     * @var string
     */
    public string $product = 'Prism Library';

    /**
     * Main Release Level
     *
     * @var int
     */
    public int $release = 2;

    /**
     * Sub Release Level
     *
     * @var int
     */
    public int $devLevel = 0;

    /**
     * Release Type
     *
     * @var string
     */
    public string $releaseType = 'Lite';

    /**
     * Development Status
     *
     * @var string
     */
    public string $devStatus = 'Stable';

    /**
     * Date
     *
     * @var string
     */
    public string $releaseDate = '31 January, 2021';

    /**
     * License
     *
     * @var string
     */
    public string $license = '<a href="http://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank">GNU/GPLv3</a>';

    /**
     * Copyright Text
     *
     * @var string
     */
    public string $copyright = '&copy; 2021 FenFex. All rights reserved.';

    /**
     * URL
     *
     * @var string
     */
    public string $url = '<a href="http://funfex.com/joomla-extensions/dev/software-development-kit" target="_blank">Prism Library</a>';

    /**
     * Developer
     *
     * @var string
     */
    public string $developer = '<a href="http://funfex.com" target="_blank">FunFex</a>';

    /**
     *  Build long format of the version text.
     *
     * @return string Long format version.
     */
    public function getLongVersion(): string
    {
        return
            $this->product . ' ' . $this->release . '.' . $this->devLevel . ' ' .
            $this->devStatus . ' ' . $this->releaseDate;
    }

    /**
     *  Build medium format of the version text.
     *
     * @return string Medium format version.
     */
    public function getMediumVersion(): string
    {
        return
            $this->release . '.' . $this->devLevel . ' ' .
            $this->releaseType . ' ( ' . $this->devStatus . ' )';
    }

    /**
     *  Build short format of the version text.
     *
     * @return string Short version format.
     */
    public function getShortVersion(): string
    {
        return $this->release . '.' . $this->devLevel;
    }
}
