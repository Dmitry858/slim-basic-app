<?php

namespace App\Controllers\Api;

use App\Models\User;
use Firebase\JWT\JWT;

class ApiController
{
    public function login($request, $response)
    {
        $input = $request->getParsedBody();
        $email = htmlspecialchars($input['email']);
        $password = sha1($input['password']);

        $user = User::where('email', $email);

        if (!$user->exists())
        {
            $result['error'] = 'User not found';
        }
        else
        {
            $user = $user->first();

            if ($password !== $user->password)
            {
                $result['error'] = 'The password is incorrect';
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
                $result['result'] = ['token' => $token];
            }
        }

        $response->getBody()->write(json_encode($result, JSON_PRETTY_PRINT));
        return $response;
    }
}