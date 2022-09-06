<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    public $formularioPerfil=[
        'Nombre'=>'required|alpha_space',
        'Apellido'=>'required|alpha_space',
        'Correo'=>'required|valid_email',
        'Direccion'=>'required|alpha_numeric_punct',
        'Ciudad'=>'required|alpha_space',
        'Pais'=>'required|alpha_space',
        'SobreMi'=>'required|alpha_numeric_punct',
        'Foto'=>'required|valid_url',
    ];

    public $formularioClienteRef=[
        'Id'=>'required|numeric',
        'Nombre'=>'required|alpha_space',
        'Apellido'=>'required|alpha_space',
        'Correo'=>'required|valid_email',
        'Ciudad'=>'required|alpha_space',
        'Pais'=>'required|alpha_space',
        'Usuario'=>'required|alpha',
    ];

    public $formularioRol=[
        'Nombre'=>'required|alpha_space',
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
}
