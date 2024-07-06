<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        if (! config('app.enable_register')) {
            return new ApiErrorResponse(
                new AuthorizationException(),
                'Register Feature disabled.',
                Response::HTTP_FORBIDDEN
            );
        }

        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return new ApiSuccessResponse($success, ['messages' => 'User register successfully']);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            return new ApiSuccessResponse($success, ['messages' => 'User Login successfully']);
        } else {
            return new ApiErrorResponse(
                new AuthorizationException(),
                'User not authorized to perform operation',
                Response::HTTP_FORBIDDEN
            );
        }
    }

    /**
     * getUser
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request): ApiSuccessResponse|ApiErrorResponse
    {
        return new ApiSuccessResponse($request->user(), ['messages' => 'Token identified successfully']);
    }
}
