<?php

namespace Admin\Form;

use Laminas\Form\Form;

class UserForm extends Form
{

    /**
     * @var array
     */
    private $roles;

    public function __construct(array $roles)
    {
        parent::__construct('user-form');

        $this->setAttribute('method', 'post');

        $this->roles = $roles;

        $this->addElements();
        $this->addInputFilter();
    }

    private function addElements(){

        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Informe o nome'
            ]
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'cpf',
            'options' => [
                'label' => 'Informe o cpf'
            ]
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'Informe o email'
            ]
        ]);

        $this->add([
            'type' => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Informe a senha'
            ]
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'roles',
            'options' => [
                'label' => 'Informe o role',
                'value_options' => $this->roles
            ]
        ]);

        // Add the CSRF field
        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ]
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Cadastrar',
                'id' => 'submit'
            ],
        ]);
    }

    private function addInputFilter(){

        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name'     => 'name',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        // Add input for "password" field
        $inputFilter->add([
            'name'     => 'cpf',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 20
                    ],
                ],
            ],
        ]);

        // Add input for "password" field
        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

    }


}