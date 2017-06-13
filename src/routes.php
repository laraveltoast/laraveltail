<?php

//\DB::listen(function($query){
//            echo "Test workd in route";
//        });
Route::get('dblog', 'laraveltoast\laraveltail\LaravelTailController@index');
