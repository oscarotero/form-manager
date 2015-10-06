<?php

use FormManager\Builder;
use FormManager\Containers\CollectionMultiple;

class CollectionMultipleTest extends BaseTest
{
    public function testBase()
    {
        $field = Builder::collectionMultiple([
            'section' => [
                'title' => Builder::text()->label('Title'),
                'text' => Builder::textarea()->label('Text'),
            ],
            'picture' => [
                'caption' => Builder::text()->label('Caption'),
                'image' => Builder::file()->label('Image'),
            ],
            'quote' => [
                'cite' => Builder::textarea()->label('Cite'),
                'author' => Builder::text()->label('Author'),
            ],
        ]);

        $this->assertInstanceOf('FormManager\\Containers\\CollectionMultiple', $field);
        $this->assertInstanceOf('FormManager\\Containers\\Group', $field->template['section']);

        return $field;
    }

    /**
     * @depends testBase
     */
    public function testValue(CollectionMultiple $field)
    {
        $field->val([
            [
                'type' => 'section',
                'title' => 'This is a title',
                'text' => 'This is a text',
            ], [
                'type' => 'picture',
                'caption' => 'This is the caption',
                'image' => [
                    'name' => '1.png',
                    'type' => 'image/png',
                    'tmp_name' => '/tmp/phpTobJ71',
                    'error' => 0,
                    'size' => 2297,
                ],
            ], [
                'type' => 'quote',
                'cite' => 'This is the cite',
                'author' => 'This is the author of the cite',
            ], [
                'type' => 'section',
                'title' => 'This is other section',
                'text' => 'This is the text of the second section',
            ],
        ]);

        $this->assertCount(4, $field->val());
        $this->assertEquals('This is a title', $field[0]['title']->val());
        $this->assertEquals('This is the cite', $field[2]['cite']->val());
    }
}
