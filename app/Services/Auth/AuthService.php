<?php

namespace App\Services\Auth;

use App\Exceptions\ChangePasswordException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\VerificationTokenExpired;
use App\Exceptions\VerificationRequestNotFound;
use App\Helpers\Utility;
use App\Models\User;
use App\Services\User\Zend\Bcrypt;
use Mail;
use Hash;
use App\Mail\EmailVerification;

/**
 * auth service class
 */
class AuthService
{


    /**
     * Verifys the token from email.
     * @param array data of registration details
     * 
     * @return void
     *
     * @throws \App\Exceptions\VerificationTokenExpired If the token has expired
     * @throws \App\Exceptions\UserNotFoundException If the user is not found
     */
    public function verifyEmailToken($token)
    {
        $user = User::where('email_token', $token)->first();
        if ($user != null) {
            $now = new \DateTime("now");
            $window = new \DateTime($user->created_at);
            $window->modify('+60 minutes');
            if ($now <= $window) {
                $user->verifyEmail();
            } else {
                throw new VerificationTokenExpired();
            }
        } else {
            throw new UserNotFoundException();
        }
    }

    /**
     * Sends the verification email 
     * @param \App\User the user
     */
    public function sendEmailVerification($user)
    {
        $email = new EmailVerification(new User(['email_token' => $user->email_token, 'name' => $user->username]));
        Mail::to($user->email)->send($email);
    }

    /**
     * Resends the verification email 
     * @param array data of registration details
     * 
     * @return void
     *
     * @throws \App\Exceptions\VerificationRequestNotFound If there is no existing request
     * @throws \App\Exceptions\UserNotFoundException If the user is not found
     */
    public function resendEmailVerification($email)
    {
        $user = User::where('email', $email)->first();
        if ($user != null) {
            if ($user->email_token != null) {
                $user->email_token = str_replace("-", "", Utility::GUIDv4());
                $user->save();
                $this->sendEmailVerification($user);
            } else {
                throw new VerificationRequestNotFound();
            }
        } else {
            throw new UserNotFoundException();
        }
    }


    /**
     * Changes user's password
     * @param App\User
     * @param array data of registration details
     * 
     * @return void
     *
     * @throws \App\Exceptions\ChangePasswordException If the old password does not match the current password
     */
    public function changePassword(User $user, $data)
    {
        if (Hash::check($data['old_password'], $user->getAuthPassword())) {
            $user->password = Hash::make($data['password']);
            $user->save();
        } else {
            throw new ChangePasswordException();
        }
    }
}
