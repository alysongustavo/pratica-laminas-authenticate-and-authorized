<?php

namespace Admin\Form;

use Laminas\Form\Form;

class RoleForm extends Form
{

    /**
     * @var array
     */
    private $rolesParent;

    public function __construct(array $rolesParent)
    {
        parent::__construct('role-form');

        $this->setAttribute('method', 'post');

        $this->rolesParent = $rolesParent;

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

        // Add "password" field
        $this->add([
            'type'  => 'textarea',
            'name' => 'description',
            'options' => [
                'label' => 'Informe a descrição',
            ]
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'parent',
            'options' => [
                'label' => 'Informe o role pai',
                'value_options' => $this->rolesParent
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
                        'max' => 128
                    ],
                ],
            ],
        ]);

        // Add input for "password" field
        $inputFilter->add([
            'name'     => 'description',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 256
                    ],
                ],
            ],
        ]);

    }

}