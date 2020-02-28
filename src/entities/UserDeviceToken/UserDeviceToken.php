<?php

namespace Oportunista\entities\UserDeviceToken;

use Illuminate\Database\Eloquent\Model;

class UserDeviceToken extends Model
{
    protected $table = 'userDeviceToken';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'lastUpdate';


}