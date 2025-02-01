<?php

namespace PhpOffice\PhpWord\Writer\EPub3\Part;

use PhpOffice\PhpWord\PhpWord;
use XMLWriter;

/**
 * Class for EPub3 content.xhtml part.
 */
class ContentXhtml extends AbstractPart
{
    /**
     * PHPWord object.
     *
     * @var ?PhpWord
     */
    private $phpWord;

    /**
     * Constructor.
     */
    public function __construct(?PhpWord $phpWord = null)
    {
        $this->phpWord = $phpWord;
    }

    /**
     * Get XML Writer.
     *
     * @return XMLWriter
     */
    protected function getXmlWriter()
    {
        $xmlWriter = new XMLWriter();
        $xmlWriter->openMemory();

        return $xmlWriter;
    }

    /**
     * Write part content.
     */
    public function write(): string
    {
        if ($this->phpWord === null) {
            throw new \PhpOffice\PhpWord\Exception\Exception('No PhpWord assigned.');
        }

        $xmlWriter = $this->getXmlWriter();

        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElement('html');
        $xmlWriter->writeAttribute('xmlns', 'http://www.w3.org/1999/xhtml');
        $xmlWriter->writeAttribute('xmlns:epub', 'http://www.idpf.org/2007/ops');
        $xmlWriter->startElement('head');
        $xmlWriter->writeElement('title', $this->phpWord->getDocInfo()->getTitle() ?: 'Untitled');
        $xmlWriter->endElement(); // head
        $xmlWriter->startElement('body');

        // Write sections content
        foreach ($this->phpWord->getSections() as $section) {
            $xmlWriter->startElement('div');
            $xmlWriter->writeAttribute('class', 'section');

            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    $xmlWriter->startElement('p');
                    foreach ($element->getElements() as $textElement) {
                        if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                            $xmlWriter->text($textElement->getText());
                        } elseif (method_exists($textElement, 'getText')) {
                            $xmlWriter->text($textElement->getText());
                        }
                    }
                    $xmlWriter->endElement(); // p
                } elseif (method_exists($element, 'getText')) {
                    $textValue = $element->getText();
                    if ($textValue instanceof \PhpOffice\PhpWord\Element\TextRun) {
                        $xmlWriter->startElement('p');
                        foreach ($textValue->getElements() as $childElement) {
                            if ($childElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                $xmlWriter->text($childElement->getText());
                            } elseif (method_exists($childElement, 'getText')) {
                                $xmlWriter->text($childElement->getText());
                            }
                        }
                        $xmlWriter->endElement(); // p
                    } else {
                        $xmlWriter->startElement('p');
                        $xmlWriter->text($textValue);
                        $xmlWriter->endElement(); // p
                    }
                }
            }

            $xmlWriter->endElement(); // div
        }

        $xmlWriter->endElement(); // body
        $xmlWriter->endElement(); // html

        return $xmlWriter->outputMemory(true);
    }
}
