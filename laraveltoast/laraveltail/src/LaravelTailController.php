<?php

namespace laraveltoast\laraveltail;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LaravelTailController extends Controller {

    public function index($timezone) {
        echo Carbon::now($timezone)->toDateTimeString();
    }

}
