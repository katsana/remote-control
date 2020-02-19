<?php

namespace RemoteControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RemoteControl\Http\Requests\CreateAccessRequest;

class CreateAccessController extends Controller
{
    /**
     * Verify remote access request.
     *
     * @return mixed
     */
    public function __invoke(CreateAccessRequest $request)
    {
        $input = $request->validated();

        \app('remote-control')->create(
            $request->user(), $input['email'], $input['content'] ?? null
        );

        return $this->sendCreatedResponse($request);
    }

    /**
     * Send the response after the access token has been created.
     *
     * @return mixed
     */
    protected function sendCreatedResponse(Request $request)
    {
        return \redirect($request->query('redirect', '/'));
    }
}
