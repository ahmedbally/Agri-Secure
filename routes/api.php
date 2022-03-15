<?php
use App\ReportPlant;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('test',function(){
    ReportPlant::where(
                    [
                        'group'=>7,
                        'year'=>2010,
                    ]
                )->where('created_at','<',now())->delete();
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
