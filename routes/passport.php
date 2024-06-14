<?php

use Laravel\Passport\Passport;

Route::group(['middleware' => ['web', 'auth']], function () {
    Passport::routes();
});