<?php

namespace App\Controllers\Api;

use App\Models\User;
use Firebase\JWT\JWT;

class ApiUserController extends ApiController
{
    public function login($request, $response)
    {
        $input = $request->getParsedBody();
        $email = htmlspecialchars($input['email']);
        $password = sha1($input['password']);

        $user = User::where('email', $email);

        if (!$user->exists())
        {
            $result = [
                'status' => 'error',
                'message' => 'User not found'
            ];
        }
        else
        {
            $user = $user->first();

            if ($password !== $user->password)
            {
                $result = [
                    'status' => 'error',
                    'message' => 'The password is incorrect'
                ];
            }
            else
            {
                $key = config('api.token.secret_key');
                $payload = array(
                    'iat' => time(), // timestamp when the JWT was created
                    'exp' => time() + config('api.token.expires_in'), // timestamp when JWT expires
                    'data' => [
                        'user_id' => $user->id,
                        'email' => $user->email
                    ]
                );

                $token = JWT::encode($payload, $key);
                $result = [
                    'status' => 'success',
                    'data' => $token
                ];
            }
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getAll($response)
    {
        $users = User::all()->toArray();
        $result = [
            'status' => 'success',
            'data' => $users
        ];
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function get($response, $id)
    {
        $userId = intval($id);
        if ($userId === 0)
        {
            $result = [
                'status' => 'error',
                'message' => 'User not found'
            ];
        }
        else
        {
            $user = User::find($userId);
            if ($user)
            {
                $user = $user->toArray();
                $result = [
                    'status' => 'success',
                    'data' => $user
                ];
            }
            else
            {
                $result = [
                    'status' => 'error',
                    'message' => 'User not found'
                ];
            }
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
}