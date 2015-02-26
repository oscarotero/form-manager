<?php
use FormManager\Builder;
use FormManager\Containers\Form;

class ValidationTest extends BaseTest
{
    public function testValidation()
    {
        $form = Builder::form([
            'name' => Builder::text()->maxlength(200)->label('Name'),
            'email' => Builder::email()->label('Email'),
            'password' => Builder::password()->label('Password'),
            'repeat_password' => Builder::password()->label('Repeat password'),
        ])->addValidator('password-check', function ($form) {
            $password1 = $form['password']->val();
            $password2 = $form['repeat_password']->val();

            if ($password1 != $password2) {
                return 'The passwords does not match';
            }

            return true;
        });

        $form->val([
            'name' => 'Oscar',
            'email' => 'oom@oscarotero.com',
            'password' => '1234',
            'repeat_password' => '12345',
        ]);

        $this->assertFalse($form->isValid());
        $this->assertEquals('The passwords does not match', $form->error());

        $form['repeat_password']->val('1234');

        $this->assertTrue($form->isValid());
        $this->assertNull($form->error());
    }
}
