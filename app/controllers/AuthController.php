<?php

class AuthController extends BaseController {

    public function login() {

        $userdata = array(
            'email'     => Input::get('email'),
            'password'  => Input::get('password'),
            'activated' => 1
        );

        if (Auth::attempt($userdata, true)) {
            return Redirect::to('space/blog');
        } else {
            return Redirect::to('login');
        }

    }

    public function logout() {
        Auth::logout();
        return Redirect::to('login');
    }

    public function status() {
        return Response::json(Auth::check());
    }

    public function user() {
        return Response::json(Auth::user());
    }

    public function passwordEqual() {
        return Response::json(Auth::user());
    }

}