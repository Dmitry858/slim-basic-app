<?php

namespace App\Controllers\Api;

use App\Models\User;

class ApiUserController
{
    public function getAll($response)
    {
        $users = User::all()->toArray();
        $response->getBody()->write(json_encode($users, JSON_PRETTY_PRINT));
        return $response;
    }

    public function get($response, $id)
    {
        $result = [];
        $userId = intval($id);
        if ($userId === 0)
        {
            $result['error'] = 'User not found';
        }
        else
        {
            $user = User::find($userId);
            if ($user)
            {
                $user = $user->toArray();
                $result['result'] = $user;
            }
            else
            {
                $result['error'] = 'User not found';
            }
        }

        $response->getBody()->write(json_encode($result, JSON_PRETTY_PRINT));
        return $response;
    }
}