<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/setup',function(){

    $credentials = [
        'password'=>'password',
        'email'=>'admin@admin.com'
    ];
    // if(Auth::attempt($credentials))
    // {
    //     return 'yes';
    // }else{
    //     return 'no';
    // }

    if(!Auth::attempt($credentials)){
        $user = new \App\Models\User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();

        if(Auth::attempt($credentials)){
             /** @var \App\Models\User $user **/
            $user = Auth::user();
            $adminToken = $user->createToken('admin-token',['create','update','delete']);
            $updateToken = $user->createToken('update-token',['create','update']);
            $basicToken = $user->createToken('basic-token',['none']);

            return [
                'admin-token'=>$adminToken->plainTextToken,
                'update-token'=>$updateToken->plainTextToken,
                'basic-token'=>$basicToken->plainTextToken
            ];
        }else{
            return Auth::attempt($credentials);
        }
    }
});
require __DIR__.'/auth.php';
