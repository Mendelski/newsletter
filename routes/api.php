<?php

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    require base_path('routes/v1.php');
});
