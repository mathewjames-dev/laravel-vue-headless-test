<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(private User $user)
    {
    }

    /**
     * Get all users. [GET /users]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        // Get all users.
        $users = $this->user->all();

        // Return users.
        return response()->json([
            'users' => $users,
        ], 200);
    }

    /**
     * Create a new user. [POST /users/create]
     *
     * @param  \App\Http\Requests\CreateUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request): \Illuminate\Http\JsonResponse
    {
        // Create user.
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'notes' => $request->notes,
        ]);

        // Return user.
        return response()->json([
            'user' => $user,
        ], 200);
    }

    /**
     * Update a user. [POST /users/{user}/update]
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, int $userId): \Illuminate\Http\JsonResponse
    {
        // Get the user.
        $user = $this->user->findOrFail($userId);

        // Update user.
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'notes' => $request->notes,
        ]);

        // Return user.
        return response()->json([
            'user' => $user,
        ], 200);
    }

    /**
     * Delete a user. [DELETE /users/{user}/delete]
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $userId): \Illuminate\Http\JsonResponse
    {
        // Get the user.
        $user = $this->user->findOrFail($userId);

        // Delete user.
        $user->delete();

        // Return message.
        return response()->json([
            'message' => 'User deleted successfully.',
        ], 200);
    }
}
