<?php

class UsersController extends BaseController {

    /**
     * Send back user by user ID
     *
     * @param int $token
     * @return Response
     */
    public function show() {

    }

    /**
     * Save new user
     *
     * @return Response
     */
    public function store() {

    }

    /**
     * Update user
     *
     * @return Response
     */
    public function update() {

        $result = false;
        $password = Input::get('password');
        $password = reset($password);

        if (Hash::check($password, Auth::user()->password)) {

            $model = Users::find(Auth::id());

            if ($model) {

                $email = Input::get('email');

                if (isset($email)) {
                    $model->email = Input::get('email');
                    //$model->activated = 0;
                }

                $result = $model->save();
            }
        } else {
            return Response::json(array('success' => Input::get('password'), 'flash' => trans('space.user_invalid_password')));
        }

        if (!$result) {
            return Response::json(array('success' => false, 'flash' => trans('space.user_update_failure')));
        } else {
            return Response::json(array('success' => true, 'flash' => trans('space.user_update_success')));
        }

    }

    /**
     * Send activate email to new email address
     *
     * @return Response
     */
    public function emailActivateNew() {

        $result = false;
        $password = Input::get('password');
        $password = reset($password);

        if (Hash::check($password, Auth::user()->password)) {

            $model = Users::find(Auth::id());

            if ($model) {

                $validator = Validator::make(Input::all(),
                    array(
                        'email' => 'required|max:100|email|unique:users',
                    )
                );

                if ($validator->fails()) {
                    return Response::json(array('success' => false, 'flash' => trans('space.user_email_FormatOrExist')));
                } else {

                    $email = Input::get('email');
                    /* Security is not so important in this case */
                    $activate_code = base64_encode($email);

                    if (isset($email)) {
                        $model->activate_code = $activate_code;
                    }

                    $result = $model->save();

                    if ($result) {

                    }
                }
            }
        } else {
            return Response::json(array('success' => false, 'flash' => trans('space.user_invalid_password')));
        }

        if (!$result) {
            return Response::json(array('success' => false, 'flash' => trans('space.user_activationEmail_failure')));
        } else {
            return Response::json(array('success' => true, 'flash' => trans('space.user_activationEmail_success')));
        }
    }

    /**
     * Send activate email to new email address
     *
     * @return Response
     */
    public function passwordChange() {

        $result = false;
        $password = Input::get('password_current');

        if (Hash::check($password, Auth::user()->password)) {

            $model = Users::find(Auth::id());

            if ($model) {

                $validator = Validator::make(Input::all(),
                    array(
                        'password_new' => 'required|min:8',
                    )
                );

                if ($validator->fails()) {
                    return Response::json(array('success' => false, 'flash' => trans('space.user_invalid_passwordFormat')));
                } else {

                    $password_new = Input::get('password_new');

                    if (isset($password_new)) {
                        $model->password = Hash::make($password_new);
                    }

                    $result = $model->save();

                }
            }
        } else {
            return Response::json(array('success' => false, 'flash' => trans('space.user_invalid_password')));
        }

        if (!$result) {
            return Response::json(array('success' => false, 'flash' => trans('space.user_updatePassword_failure')));
        } else {
            return Response::json(array('success' => true, 'flash' => trans('space.user_updatePassword_success')));
        }
    }

}
