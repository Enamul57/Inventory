<?php

    namespace App\Http\Controllers;
    use Auth;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;

    class UserController extends Controller
    {
        public function authenticate(Request $request)
        {
            $validation = $request->validate([
                'email'=>'required',
                'password'=>'required'
            ]);
            $credentials = $request->only('email', 'password');
            $email = $request->email;
            $user = DB::table('users')->where('email',$email)->first();
            $userName = $user->name;
            $userId = $user->id;
            $userEmail = $user->email;
            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            // return response()->json(compact('token'));
             return response()->json(compact('token','userId','userName','userEmail'));
            
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            // $user = User::create([
            //     'name' => $request->get('name'),
            //     'email' => $request->get('email'),
            //     'password' => Hash::make($request->get('password')),
            // ]);
            $User = new User;
            $User->name = $request->name;
            $User->email = $request->email;
            $User->password = Hash::make($request->password);
             $User->save(); 
             $person = User::where('email',$request->email)->first();
             $user = $person->name;
               
            $token = JWTAuth::fromUser($User);

            return response()->json(compact('user','token'),201);
        }
        //logout
        public function logout()
        {
            auth()->logout();
    
            return response()->json(['message' => 'Successfully logged out']);
        }
    
        public function getAuthenticatedUser()
            {
                    try {

                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
            }
    }