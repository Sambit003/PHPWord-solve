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
 * Class for ePub3 paragraph styles.
 */
class Paragraph extends AbstractStyle
{
    /**
     * Write style content.
     *
     * @return string
     */
    public function write()
    {
        $content = 'p {';
        $content .= 'margin-top: 0;';
        $content .= 'margin-bottom: 1em;';
        $content .= 'text-align: left;';
        $content .= '}';

        return $content;
    }
}