<?php

namespace StreetSignal\Modules\V5\Http\Controllers;

use Illuminate\Http\Request;
use StreetSignal\Modules\V5\Actions\Auth\Commands\RegisterCommand;
use StreetSignal\Modules\V5\Actions\Auth\Commands\PasswordResetCommand;
use StreetSignal\Modules\V5\Actions\Auth\Commands\PasswordResetConfirmCommand;
use StreetSignal\Modules\V5\Requests\RegisterRequest;
use StreetSignal\Modules\V5\Requests\ResetPasswordRequest;
use StreetSignal\Modules\V5\Requests\PasswordresetConfirmRequest;
use StreetSignal\Modules\V5\Http\Resources\User\UserResource;
use StreetSignal\Modules\V5\Actions\User\Queries\FetchUserByIdQuery;
use StreetSignal\Modules\V5\Models\User;


use StreetSignal\Core\Exception\NotFoundException;

class AuthController extends V5Controller
{



    /**
     * signup new User.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $this->authorizeAnyone('register', new User());

        $id = $this->commandBus->handle(RegisterCommand::fromRequest($request));
        return new UserResource($this->queryBus->handle(new FetchUserByIdQuery($id)));
    } //end register()


    /**
     * reset password.
     *
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $this->commandBus->handle(PasswordResetCommand::fromRequest($request));
        return response()->json(['result' => ['mail-to-reset-password' => true]]);
    } //end register()


    /**
     * confirm reset password.
     *
     * @param PasswordresetConfirmRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm(PasswordresetConfirmRequest $request)
    {
        if ($this->commandBus->handle(PasswordResetConfirmCommand::fromRequest($request))) {
            return response()->json(['result' => ['confirm-reset-password' => true]]);
        } else {
            return response()->json(['result' => ['confirm-reset-password' => false]]);
        }

        $command = PasswordResetConfirmCommand::fromRequest($request);
    } //end register()
} //end class
