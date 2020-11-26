<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Credentials does not match'
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken($user->code, [$user->profile])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'User logout successfuly'
        ], 200);
    }

    // protected function token_expires($created_at, $minutes_expires)
    // {
    //     $date_token =  new DateTime($created_at);
    //     // $date_token = $date_token->format('d-m-Y H:i:s');

    //     $date_add_month = now();
    //     // $date_add_month = $date_add_month->format('d-m-Y H:i:s');

    //     $date_interval = $date_token->diff($date_add_month);

    //     return $date_interval->format('%i') . PHP_EOL < $minutes_expires ? false : true;
    // }
}
