<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use \Illuminate\Http\Response;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
class UserController extends Controller
{

    /**
     * Get Users
    */
    public function index(Request $request, UserService $userService)
    {
        try {

            if($request->ajax()) {
                return $userService->index();
            }

            return view('admin.users');

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get User
    */
    public function show(User $user)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'user' => $user
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store User
     * @param Request $request
     * @param Service $userService
     * @return User
    */
    public function store(UserRequest $request, UserService $userService)
    {
        try {

            $request = $request->validated();
            $request = Arr::add($request, 'password', Hash::make('password'));

            $user = $userService->store($request);

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'User Created Successfully',
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update User
     * @param UserRequest $request
     * @param User $user
     * @param Service $userService
     * @return User
    */
    public function update(UserRequest $request, User $user, UserService $userService)
    {
        try {
            $user = $userService->update($user, $request->validated());

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'User Updated Successfully',
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete User
     * @param User $user
     * @param Service $userService
     * @return User
    */
    public function destroy(User $user, UserService $userService)
    {
        try {
            if(!$user){
                return response()->json([
                    'status' => true,
                    'message' => 'User not found!',
                ], Response::HTTP_NOT_FOUND);
            }
            //check if auth user is equal to the user param
            if(Auth::user()->id === $user->id) {
                return response()->json([
                    'status' => true,
                    'message' => 'Forbidden',
                ], Response::HTTP_FORBIDDEN);
            }


            $userService->destroy($user);

            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully',
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
