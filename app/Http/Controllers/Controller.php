<?php
 namespace AppHttpControllers; namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends Controller {

	use DispatchesCommands, ValidatesRequests;

}
