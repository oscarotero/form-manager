<?php
declare(strict_types = 1);

namespace FormManager\Tests;

use FormManager\Nodes\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function testBasicMethods()
    {
        $node = new Node('div');

        $this->assertEquals('div', $node->getNodeName());
        $this->assertSame(null, $node->getParentNode());
        $this->assertCount(0, $node->getChildNodes());
        $this->assertEquals('<div>', $node->getOpeningTag());
        $this->assertEquals('</div>', $node->getClosingTag());

        $node->setAttribute('class', 'fancy');
        $this->assertEquals('fancy', $node->getAttribute('class'));
        $this->assertEquals('fancy', $node->class);
        $this->assertEquals('<div class="fancy"></div>', (string) $node);

        $node->class = ['fancy', 'red'];
        $this->assertEquals(['fancy', 'red'], $node->getAttribute('class'));
        $this->assertEquals('<div class="fancy red"></div>', (string) $node);

        $node->removeAttribute('class');
        $this->assertNull($node->getAttribute('class'));
        $this->assertEquals('<div></div>', (string) $node);

        $node->setVariable('foo', 'bar');
        $this->assertEquals('bar', $node->getVariable('foo'));

        $node->appendChild(new Node('p'));
        $this->assertCount(1, $node->getChildNodes());
        $this->assertSame($node, $node->getChildNodes()[0]->getParentNode());
    }

    public function attributesProvider()
    {
        return [
            ['class', 'foo', '<div class="foo">'],
            ['class', ['foo', 'bar'], '<div class="foo bar">'],
            ['accept', ['foo', 'bar'], '<div accept="foo, bar">'],
            ['accept-charset', ['foo', 'bar'], '<div accept-charset="foo, bar">'],
            ['data-charset', ['foo', 'bar'], '<div data-charset="[&quot;foo&quot;,&quot;bar&quot;]">'],
            ['checked', true, '<div checked>'],
            ['checked', false, '<div>'],
            ['checked', null, '<div>'],
        ];
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testAttributes(string $name, $value, string $code)
    {
        $node = new Node('div');
        $node->setAttribute($name, $value);
        $this->assertEquals($code, $node->getOpeningTag());
    }

    public function tagsProvider(): array
    {
        return [
            ['div', '<div></div>'],
            ['area', '<area>'],
            ['base', '<base>'],
            ['br', '<br>'],
            ['col', '<col>'],
            ['embed', '<embed>'],
            ['hr', '<hr>'],
            ['img', '<img>'],
            ['input', '<input>'],
            ['link', '<link>'],
            ['meta', '<meta>'],
            ['param', '<param>'],
            ['source', '<source>'],
            ['track', '<track>'],
            ['wbr', '<wbr>'],
            ['a', '<a></a>'],
        ];
    }

    /**
     * @dataProvider tagsProvider
     */
    public function testSelfClosing(string $name, string $code)
    {
        $node = new Node($name);
        $this->assertEquals($code, (string) $node);
    }

    public function testCloning()
    {
        $node = new Node('div');
        $node->setAttribute('id', 'foo');
        $node->appendChild(new Node('p'));
        $this->assertSame($node, $node->getChildNodes()[0]->getParentNode());

        $clone = clone $node;
        $this->assertEmpty($clone->getAttribute('id'));
        $this->assertSame($clone, $clone->getChildNodes()[0]->getParentNode());
    }

    public function testAppendChildren()
    {
        $node = new Node('div');
        $node->appendChild(new Node('p'));
        $node->appendChild(new Node('hr'));

        $this->assertEquals('<div><p></p><hr></div>', (string) $node);
    }
}
