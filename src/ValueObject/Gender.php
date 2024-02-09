<?php

namespace App\ValueObject;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case NA = 'n/a';
}
