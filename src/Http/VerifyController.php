<?php

namespace RemoteControl\Http;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VerifyController extends Controller
{
    /**
     * Verify remote access request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $secret
     *
     * @return mixed
     */
    public function __invoke(Request $request, $secret)
    {
        $verificationCode = $request->query('verification_code');
        $email = $request->query('email');

        $remote = \app('remote-control')->authenticate(
            $email, $secret, $verificationCode
        );

        \abort_if(! $remote, 404);

        return \redirect(\config('remote-control.redirect', '/'));
    }
}
