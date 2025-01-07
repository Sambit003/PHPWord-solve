<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 *
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Writer\ePub3\Style;

/**
 * Class for ePub3 font styles.
 */
class Font extends AbstractStyle
{
    /**
     * Write style content.
     *
     * @return string
     */
    public function write()
    {
        $content = 'body {';
        $content .= 'font-family: "Times New Roman", Times, serif;';
        $content .= 'font-size: 12pt;';
        $content .= 'color: #000000;';
        $content .= '}';

        return $content;
    }
}