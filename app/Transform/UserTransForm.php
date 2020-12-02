<?php
namespace App\Transform;

use App\Models\User;
use League\Fractal\TransformerAbstract;


class UserTransform extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }
}