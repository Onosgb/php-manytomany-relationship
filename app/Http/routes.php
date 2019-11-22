<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Role;
use App\User;

Route::get('/', function () {
    return view('welcome');
});


#create method for many to many relationship
Route::get('/create', function() {
    $user = User::findOrFail(1);
    $role = new Role();
    $role->name = "Administrator";

    $user->roles()->save($role);
});

#read method for many to many relationship
Route::get('/read', function() {
    $user = User::findOrFail(1);

    foreach($user->roles as $role) {
        echo $role->pivot;
        // dd($role);
    }
});

#updating the database
Route::get('/update', function() {
    $user = User::findOrFail(1);

    if($user->has('roles')) {
        foreach($user->roles as $role) {
            if($role->name == 'Administrator') {
                $role->name =" administrator";
                $role->save();
            }
        }
    }
});

#delete role method

Route::get('/delete', function() {
    $user = User::findOrFail(1);

    foreach($user->roles as $role) {
        $role->whereId(1)->delete();
    }
});


// method to attach role to a user but. It does not know is role has already been attached, 
// what it does is continues attachment even if role exist for the user

Route::get('/attach', function(){
$user = User::findOrFail(1);
$user->roles()->attach(1);
});

Route::get('/detach', function(){
$user = User::findOrFail(1);
$user->roles()->detach(1);
});

# the sync method allow you to create more than one role at a time.
# But delete other roles if any of the roles are not found.

Route::get('/sync', function(){
    $user = User::findOrFail(1);
    $user->roles()->sync([1]);
});