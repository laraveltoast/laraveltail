<?php

namespace laraveltoast\laraveltail;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use laraveltoast\laraveltail\LaravelTailCommand;

class LaravelTailController extends Controller {

    public function index($timezone = null) {
        $path = \laraveltoast\laraveltail\LaravelTailCommand::findLogfile();

        $file = fopen($path, "r");
        $contents = " ";
        try {
            // While end of file not reached ->
            while (!feof($file)) {
                // Get next row from file and convert special characters to HTML entities
                $contents .= "<li>" . htmlspecialchars(fgets($file)) . "</li>";
            }
        } catch (Exception $e) {
            // Close pointer to file
            fclose($file);
        }
        return view('laraveltail::db_log', compact('contents'));
    }

}
