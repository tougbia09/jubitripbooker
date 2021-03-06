<?php

class Login_Controller extends Base_Controller {

    public function action_index()
    {
        if (Session::get('logged_in') == true) {
            return Redirect::to('user');
        } else {
            return View::make('login.index');
        }
    }

    public function action_check()
    {
        $rules = array(
            'firstname' => 'required|max:40|alpha',
            'lastname' => 'required|max:40|alpha',
            'number' => 'required|integer'
        );

        $validation = Validator::make(Input::all(), $rules);
        
        if ($validation->fails()) {
            return Redirect::to('login/error');
        }

        $user = Users::get(Input::get('firstname'), Input::get('lastname'), Input::get('number'));

        if ($user != null) {
            $name = $user->firstname." ".$user->lastname;
            Session::put('uid', $user->id);
            Session::put('name', $name);
            Session::put('logged_in', true);
            return Redirect::to('user');
        } else {
            return Redirect::to('login/error');
        }
    }

    public function action_error()
    {
        return View::make('login.index')->with('error', true);
    }

    public function action_logout()
    {
        Session::flush();
        return View::make('login.index');
    }
    
}
