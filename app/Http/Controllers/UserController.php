<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    /**
     * This is the endpoint for creating a new user.
     * POST - {{url}}/api/v1/user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try{
            /*
             * We check if the required inputs are supplied & valid
             */
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);

            /*
             * If some inputs fail the validation check,
             * we return a response containing error messages
             */
            if($validator->fails()){
                return response()->json([
                    'status' => 'failed',
                    'messages' => $validator->errors()->all()
                ], 400);
            }

            /*
             * Since all inputs are valid/correct
             * we can proceed to create a new User.
             */
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            /*
             * We return a 201 resource created status code,
             * and data payload containing new User.
             */
            return response()->json([
                'status' => 'success',
                'messages' => [
                    'User created successfully'
                ],
                'data' => [
                    'user' => $user
                ]
            ], 201);

        }catch(Throwable $exception){
            /*
             * In case of an error/exception, we will report to our exception service
             * and return generic response to User, without leaking sensitive information.
             */
            report($exception);
            return response()->json([
                'status' => 'failed',
                'messages' => [
                    'An error occurred while trying to create new user.'
                ]
            ], 500);
        }
    }


    /**
     * This endpoint is used to retrieve a user id.
     * GET {{url}}/api/v1/user/:id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        try{
            /*
             * We validate the input to check that the required
             * id is provided and also in the expected data type.
             */
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 'failed',
                    'messages' => $validator->errors()->all()
                ], 400);
            }

            /*
             * We query the database for user with associated id,
             * this query expression returns a User object
             * if found or null if user is not found.
             */
            $user = User::where('id', $id)->first();

            /*
             * In the event that we get null as the result,
             * we return a 404 not found status code & error message.
             */
            if(!$user){
                return response()->json([
                    'status' => 'failed',
                    'messages' => [
                        "User with id {$id} not found."
                    ]
                ], 404);
            }

            /*
             * User found in our database, so we return a
             * 200 status code and data payload with user.
             */
            return response()->json([
                'status' => 'success',
                'messages' => [
                    'User retrieved successfully'
                ],
                'data' => [
                    'user' => $user
                ]
            ], 200);

        }catch(Throwable $exception){
            /*
             * In case of an error/exception, we will report to our exception service
             * and return generic response to User, without leaking sensitive information.
             */
           report($exception);
           return response()->json([
               'status' => 'failed',
               'messages' => [ $exception->getMessage(),
                   "An error occurred while trying to retrieve User with id {$id}."
               ]
           ], 500);
        }
    }
}
