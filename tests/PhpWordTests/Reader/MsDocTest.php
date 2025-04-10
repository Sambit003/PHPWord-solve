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

namespace PhpOffice\PhpWordTests\Reader;

use Exception;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Reader\MsDoc;

/**
 * Test class for PhpOffice\PhpWord\Reader\MsDoc.
 *
 * @coversDefaultClass \PhpOffice\PhpWord\Reader\MsDoc
 *
 * @runTestsInSeparateProcesses
 */
class MsDocTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test canRead() method.
     */
    public function testCanRead(): void
    {
        $object = new MsDoc();
        $filename = __DIR__ . '/../_files/documents/reader.doc';
        self::assertTrue($object->canRead($filename));
    }

    /**
     * Can read exception.
     */
    public function testCanReadFailed(): void
    {
        $object = new MsDoc();
        $filename = __DIR__ . '/../_files/documents/foo.doc';
        self::assertFalse($object->canRead($filename));
    }

    public function testLoadBasic(): void
    {
        $filename = __DIR__ . '/../_files/documents/reader.doc';
        $phpWord = IOFactory::load($filename, 'MsDoc');
        self::assertInstanceOf(PhpWord::class, $phpWord);

        $sections = $phpWord->getSections();
        self::assertCount(1, $sections);
        $elements = $sections[0]->getElements();
        self::assertArrayHasKey(0, $elements);
        /** @var Text $element0 */
        $element0 = $elements[0];
        self::assertInstanceOf(Text::class, $element0);
        self::assertEquals('Welcome to PhpWord', $element0->getText());
    }

    public function testLoadHalfPointFont(): void
    {
        $filename = __DIR__ . '/../_files/documents/reader.font-halfpoint.doc';
        $phpWord = IOFactory::load($filename, 'MsDoc');
        $sections = $phpWord->getSections();
        self::assertCount(1, $sections);
        $elements = $sections[0]->getElements();
        self::assertArrayHasKey(0, $elements);
        $element0 = $elements[0];
        if (method_exists($element0, 'getFontStyle')) {
            self::assertSame(19.5, $element0->getFontStyle()->getSize());
        } else {
            self::fail('Unexpected no font style for first element');
        }
    }

    public function testLoadChinese(): void
    {
        $filename = __DIR__ . '/../_files/documents/docChinese.doc';
        $phpWord = IOFactory::load($filename, 'MsDoc');
        self::assertInstanceOf(PhpWord::class, $phpWord);

        $sections = $phpWord->getSections();
        self::assertCount(1, $sections);
        $elements = $sections[0]->getElements();
        self::assertArrayHasKey(0, $elements);
        /** @var Text $element0 */
        $element0 = $elements[0];
        self::assertInstanceOf(Text::class, $element0);
        self::assertEquals('OKKI AI 客户案例', $element0->getText());
    }

    public function testLoadCzech(): void
    {
        $filename = __DIR__ . '/../_files/documents/docCzech.doc';
        $phpWord = IOFactory::load($filename, 'MsDoc');
        self::assertInstanceOf(PhpWord::class, $phpWord);

        $sections = $phpWord->getSections();
        self::assertCount(1, $sections);
        $elements = $sections[0]->getElements();
        self::assertArrayHasKey(0, $elements);
        /** @var Text $element0 */
        $element0 = $elements[0];
        self::assertInstanceOf(Text::class, $element0);
        self::assertEquals('Příliš žluťoučký kůň pěl ďábelské ódy', $element0->getText());
    }

    public function testLoadSlovak(): void
    {
        $filename = __DIR__ . '/../_files/documents/docSlovak.doc';
        $phpWord = IOFactory::load($filename, 'MsDoc');
        self::assertInstanceOf(PhpWord::class, $phpWord);

        $sections = $phpWord->getSections();
        self::assertCount(1, $sections);
        $elements = $sections[0]->getElements();
        self::assertArrayHasKey(0, $elements);
        /** @var Text $element0 */
        $element0 = $elements[0];
        self::assertInstanceOf(Text::class, $element0);
        self::assertEquals('Pondelok', $element0->getText());
    }

    /**
     * Test exception on not existing file.
     */
    public function testFailIfFileNotReadable(): void
    {
        $this->expectException(Exception::class);
        $filename = __DIR__ . '/../_files/documents/not_existing_reader.doc';
        IOFactory::load($filename, 'MsDoc');
    }

    /**
     * Test exception on non OLE document.
     */
    public function testFailIfFileNotOle(): void
    {
        $this->expectException(Exception::class);
        $filename = __DIR__ . '/../_files/documents/reader.odt';
        IOFactory::load($filename, 'MsDoc');
    }
}
