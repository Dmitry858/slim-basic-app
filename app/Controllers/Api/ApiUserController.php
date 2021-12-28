<?php

namespace App\Controllers\Api;

use App\Models\User;
use Firebase\JWT\JWT;

class ApiUserController extends ApiController
{
    public function login($request, $response)
    {
        $data = $request->getParsedBody();
        $email = htmlspecialchars($data['email']);
        $password = sha1($data['password']);

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
        if (config('app.cache.enable'))
        {
            if ($this->cache->get('users'))
            {
                $users = $this->cache->get('users');
            }
            else
            {
                $users = User::all()->toArray();
                $this->cache->add('users', $users);
            }
        }
        else
        {
            $users = User::all()->toArray();
        }

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

    public function create($request, $response)
    {
        $data = $request->getParsedBody();
        $name = htmlspecialchars($data['name']);
        $email = htmlspecialchars($data['email']);
        $password = sha1($data['password']);

        if (!$data['name'] || !$data['email'] || !$data['password'])
        {
            $result = [
                'status' => 'error',
                'message' => 'Empty field'
            ];
        }
        else
        {
            if (User::where('email', $email)->exists())
            {
                $result = [
                    'status' => 'error',
                    'message' => 'User with email ' . $email . ' exists'
                ];
            }
            else
            {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                ]);
                $user->save();

                if (config('app.cache.enable'))
                {
                    $this->cache->delete('users');
                }

                $result = [
                    'status' => 'success',
                    'message' => 'User created',
                    'id' => $user->id
                ];
            }
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function update($request, $response, $id)
    {
        $data = $request->getParsedBody();

        $needUpdate = false;
        if ($data['$name'] || $data['email'] || $data['password'])
        {
            $needUpdate = true;
        }

        $userId = intval($id);
        if ($userId === 0 || !$needUpdate)
        {
            $result = [];
        }
        else
        {
            $user = User::find($userId);
            if ($user)
            {
                $name = htmlspecialchars($data['name']);
                $email = htmlspecialchars($data['email']);
                $password = sha1($data['password']);

                if ($name) $user->name = $name;
                if ($email) $user->email = $email;
                if ($data['password']) $user->password = $password;
                $user->save();

                if (config('app.cache.enable'))
                {
                    $this->cache->delete('users');
                }

                $result = [
                    'status' => 'success',
                    'message' => 'User updated'
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

    public function delete($response, $id)
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
                $res = $user->delete();
                if (!$res)
                {
                    $result = [
                        'status' => 'error',
                        'message' => 'Unknown reason'
                    ];
                }
                else
                {
                    if (config('app.cache.enable'))
                    {
                        $this->cache->delete('users');
                    }
                    $result = [
                        'status' => 'success',
                        'message' => 'User deleted',
                        'id' => $userId
                    ];
                }
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