<?php
use FormManager\Inputs\Input;

include_once __DIR__.'/../src/autoloader.php';

class InputTest extends PHPUnit_Framework_TestCase
{
    private function genericElementTest($input)
    {
        $input->name('input-name');
        $this->assertEquals('input-name', $input->attr('name'));
        $this->assertNull($input->val());

        $input->data('name', 'value');
        $this->assertEquals('value', $input->data('name'));
        $this->assertEquals(['name' => 'value'], $input->data());

        $this->assertNull($input->attr('class'));
        $input->addClass('first');
        $input->addClass('second');
        $this->assertEquals('first second', $input->attr('class'));

        $input->removeClass('second');
        $this->assertEquals('first', $input->attr('class'));

        $input->set('myVar', ['one', 'two']);
        $this->assertEquals(['one', 'two'], $input->get('myVar'));
    }

    private function genericInputTest($input, $type = null)
    {
        $this->assertEquals($type, $input->attr('type'));
        $this->assertEquals('', $input->closeHtml());

        $html = '<input type="'.$type.'" name="input-name" class="first" data-name="value">';
        $this->assertEquals($html, $input->toHtml());
    }

    public function testCheckbox()
    {
        $input = Input::checkbox();

        $this->assertEquals('checkbox', $input->attr('type'));
    }

    public function testEmail()
    {
        $input = Input::email();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'email');

        //Values
        $input->val('invalid-email');
        $this->assertFalse($input->isValid());

        $input->val('valid@email.com');
        $this->assertTrue($input->isValid());
        $this->assertEquals('valid@email.com', $input->val());
    }

    public function testFile()
    {
        $input = Input::file();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'file');

        $input->val(array(
            'name' => 'image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__.'/image.jpg',
            'error' => 1,
        ));

        $this->assertFalse($input->isValid());
        $this->assertEquals('The uploaded file exceeds the upload_max_filesize directive in php.ini', $input->error());

        $input->val(array(
            'name' => 'image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__.'/image.jpg',
            'error' => 0,
        ));

        $input->accept('image/png');

        $this->assertFalse($input->isValid());

        $input->val(array(
            'name' => 'image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__.'/image.jpg',
            'error' => 0,
        ));

        $input->accept('image/jpeg');

        $this->assertTrue($input->isValid(), $input->error());

        $input->required();

        $this->assertFalse($input->isValid());
    }

    public function testHidden()
    {
        $input = Input::hidden();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'hidden');
    }

    public function testNumber()
    {
        $input = Input::number();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'number');

        //Values
        $input->val('not a number');
        $this->assertFalse($input->isValid());

        $input->val('25');
        $this->assertTrue($input->isValid());
        $this->assertEquals('25', $input->val());

        $input->val('25.5');
        $this->assertTrue($input->isValid());

        $input->val('');
        $this->assertTrue($input->isValid());

        $input->val('0');
        $this->assertTrue($input->isValid());

        $input->min(0);
        $this->assertTrue($input->isValid());
    }

    public function testPassword()
    {
        $input = Input::password();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'password');
    }

    public function testRadio()
    {
        $input = Input::radio();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'radio');

        //Check/uncheck
        $this->assertNull($input->attr('checked'));

        $input->check();
        $this->assertTrue($input->attr('checked'));

        $input->uncheck();
        $this->assertNull($input->attr('checked'));
    }

    public function testRange()
    {
        $input = Input::range();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'range');

        //Values
        $input->val('not a number');
        $this->assertFalse($input->isValid());

        $input->val('25');
        $this->assertTrue($input->isValid());

        $input->min(5)->max(10);
        $this->assertFalse($input->isValid());

        $input->val(5);
        $this->assertTrue($input->isValid());

        $input->val(10);
        $this->assertTrue($input->isValid());

        $input->val(10.1);
        $this->assertFalse($input->isValid());
    }

    public function testSearch()
    {
        $input = Input::search();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'search');
    }

    public function testSelect()
    {
        $input = Input::select();

        $this->genericElementTest($input);

        $this->assertNull($input->attr('type'));

        //Values
        $input->options([
            '' => 'Empty',
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
        ]);

        $input->val('three');
        $this->assertFalse($input->isValid());

        $input->val('One');
        $this->assertFalse($input->isValid());

        $input->val('1');
        $this->assertTrue($input->isValid());

        $input->allowNewValues();
        $input->val('new-value');
        $this->assertTrue($input->isValid());

        $input->val('');
        $this->assertSame($input->val(), '')

        ;
        $input->val(0);
        $this->assertSame($input->val(), 0);

        $input->val(1);
        $this->assertSame($input->val(), 1);

        $input->val('1');
        $this->assertSame($input->val(), '1');
    }

    public function testSubmit()
    {
        $input = Input::submit();

        $this->genericElementTest($input);

        $this->assertEquals('submit', $input->attr('type'));
    }

    public function testTel()
    {
        $input = Input::tel();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'tel');
    }

    public function testText()
    {
        $input = Input::text();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'text');

        //Validators
        $input->maxlength(5);

        $input->val('String');
        $this->assertFalse($input->isValid());

        $input->val('Strin');
        $this->assertTrue($input->isValid());

        $input->required();

        $input->val('');
        $this->assertFalse($input->isValid());

        $input->val('0');
        $this->assertTrue($input->isValid());

        $input->pattern('[0-9]');

        $this->assertTrue($input->isValid());

        $input->val('nn');

        $this->assertFalse($input->isValid());

        $input->pattern('/[a-z]{2}/');

        $input->val('/a/');

        $this->assertFalse($input->isValid());

        $input->val('/ab/');

        $this->assertTrue($input->isValid());

        $input->addValidator('is-dave', function ($input) {
            return ($input->val() === 'dave') ?: 'This value must be "dave"';
        });

        $this->assertFalse($input->isValid());

        $input->removeAttr('pattern');
        $input->val('dave');

        $this->assertTrue($input->isValid());
    }

    public function testTextarea()
    {
        $input = Input::textarea();

        $this->genericElementTest($input);

        $this->assertNull($input->attr('type'));
    }

    public function testUrl()
    {
        $input = Input::url();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'url');

        //Values
        $input->val('invalid-url');
        $this->assertFalse($input->isValid());

        $input->val('http://valid-url.com');
        $this->assertTrue($input->isValid());
        $this->assertEquals('http://valid-url.com', $input->val());
    }

    public function testDatetime()
    {
        $input = Input::datetime();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'datetime');

        //Values
        $input->val('2005-33-14T15:52:01+00:00');
        $this->assertFalse($input->isValid());

        $input->val('Mon, 15 Aug 2005 15:52:01 +0000');
        $this->assertTrue($input->isValid());
        $this->assertEquals('2005-08-15T15:52:01+00:00', $input->val());

        $input->max('2005-08-14T15:52:01+00:00');
        $this->assertFalse($input->isValid());

        $input->max('2005-08-15T15:52:01+00:00');
        $this->assertTrue($input->isValid());

        $input->max('2005-08-16T15:52:01+00:00');
        $this->assertTrue($input->isValid());
    }

    public function testDatetimeLocal()
    {
        $input = Input::datetimeLocal();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'datetime-local');

        //Values
        $input->val('2005-33-14T15:52:01');
        $this->assertFalse($input->isValid());

        $input->val('Mon, 15 Aug 2005 15:52:01');
        $this->assertTrue($input->isValid());
        $this->assertEquals('2005-08-15T15:52:01', $input->val());

        $input->max('2005-08-14T15:52:01');
        $this->assertFalse($input->isValid());

        $input->max('2005-08-15T15:52:01');
        $this->assertTrue($input->isValid());

        $input->max('2005-08-16T15:52:01');
        $this->assertTrue($input->isValid());
    }

    public function testDate()
    {
        $input = Input::date();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'date');

        //Values
        $input->val('2005-33-14');
        $this->assertFalse($input->isValid());

        $input->val('Mon, 15 Aug 2005');
        $this->assertTrue($input->isValid());
        $this->assertEquals('2005-08-15', $input->val());

        $input->max('2005-08-14');
        $this->assertFalse($input->isValid());

        $input->max('2005-08-15');
        $this->assertTrue($input->isValid());

        $input->max('2005-08-16');
        $this->assertTrue($input->isValid());

        $input->min('2005-08-16');
        $this->assertFalse($input->isValid());
    }

    public function testTime()
    {
        $input = Input::time();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'time');

        //Values
        $input->val('38:34:32');
        $this->assertFalse($input->isValid());

        $input->val('18:34:32');
        $this->assertTrue($input->isValid());
        $this->assertEquals('18:34:32', $input->val());

        $input->max('18:34:31');
        $this->assertFalse($input->isValid());

        $input->max('18:34:32');
        $this->assertTrue($input->isValid());

        $input->max('18:34:33');
        $this->assertTrue($input->isValid());

        $input->min('18:34:33');
        $this->assertFalse($input->isValid());
    }

    public function testMonth()
    {
        $input = Input::month();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'month');

        //Values
        $input->val('2014-33');
        $this->assertFalse($input->isValid());

        $input->val('2014-09');
        $this->assertTrue($input->isValid());
        $this->assertEquals('2014-09', $input->val());

        $input->max('2014-08');
        $this->assertFalse($input->isValid());

        $input->max('2014-09');
        $this->assertTrue($input->isValid());

        $input->max('2014-10');
        $this->assertTrue($input->isValid());

        $input->min('2014-10');
        $this->assertFalse($input->isValid());
    }

    public function testWeek()
    {
        $input = Input::week();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'week');

        //Values
        $input->val('2014-W55');
        $this->assertFalse($input->isValid());

        $input->val('2014-W16');
        $this->assertTrue($input->isValid());
        $this->assertEquals('2014-W16', $input->val());

        $input->max('2014-W15');
        $this->assertFalse($input->isValid());

        $input->max('2014-W16');
        $this->assertTrue($input->isValid());

        $input->max('2014-W17');
        $this->assertTrue($input->isValid());

        $input->min('2014-W17');
        $this->assertFalse($input->isValid());
    }

    public function testColor()
    {
        $input = Input::color();

        $this->genericElementTest($input);
        $this->genericInputTest($input, 'color');

        //Values
        $input->val('red');
        $this->assertFalse($input->isValid());

        $input->val('11234f');
        $this->assertFalse($input->isValid());

        $input->val('#11234f');
        $this->assertTrue($input->isValid());
        $this->assertEquals('#11234f', $input->val());
    }
}
