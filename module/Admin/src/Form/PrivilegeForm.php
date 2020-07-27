<?php

namespace Admin\Form;

use Laminas\Form\Form;

class PrivilegeForm extends Form
{

    /**
     * @var array
     */
    private $roles;

    private $resources;

    public function __construct(array $roles, array $resources)
    {
        parent::__construct('privilege-form');

        $this->setAttribute('method', 'post');

        $this->roles = $roles;
        $this->resources = $resources;

        $this->addElements();
        $this->addInputFilter();
    }

    private function addElements(){

        $this->add([
            'type' => 'text',
            'name' => 'permissions',
            'options' => [
                'label' => 'Informe as permissoes'
            ]
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'resource',
            'options' => [
                'label' => 'Informe o resource',
                'value_options' => $this->resources
            ]
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'role',
            'options' => [
                'label' => 'Informe o resource',
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
            'name'     => 'permissions',
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

    }

}