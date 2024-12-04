<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use KanekiYuto\Handy\Foundation\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizeContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Authenticate extends Model implements
    AuthorizeContract,
    AuthenticateContract,
    CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

}
