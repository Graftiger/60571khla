<?php

namespace App\Services;

use App\Models\IonAuthModelGoogle;
use IonAuth\Libraries\IonAuth;

class IonAuthGoogle extends IonAuth
{

    /**
     * IonAuthGoogle constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->ionAuthModel = new IonAuthModelGoogle();
        $this->ionAuthModel->triggerEvents('library_constructor');
    }
}