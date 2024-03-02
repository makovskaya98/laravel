<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhoneNumber extends Controller
{
    public $countrycode;
    public $phone;

    public function __construct(string $countrycode, string $phone)
    {
        $this->countrycode = $countrycode;
        $this->phone = $phone;
    }
}
