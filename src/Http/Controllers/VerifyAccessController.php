<?php

namespace RemoteControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VerifyAccessController extends Controller
{
    /**
     * Verify remote access request.
     *
     * @param string $secret
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

        return $this->sendAuthenticatedResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @return mixed
     */
    protected function sendAuthenticatedResponse(Request $request)
    {
        return \redirect($request->query('redirect', '/'));
    }
}
