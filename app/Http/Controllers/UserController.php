<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\Contracts\UsersInterface;
use App\Utility\ResponseMessage;
use App\Utility\ResponseCode;

class UserController extends Controller
{
    protected $userModel;

    public function __construct(UsersInterface $userModel){
        $this->userModel = $userModel;
    }
    
    public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phoneNumber'=> 'required|string|min:7',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|string|min:1'
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $lastname = $request->get('lastname');
            $firstname = $request->get('firstname');
            $name = $firstname.' '.$lastname; 

            $user = $this->userModel->create([
                'name' => $name,
                'email' => $request->get('email'),
                'phone'=> $request->get('phoneNumber'),
                'password' => Hash::make($request->get('password')),
                'role'=> $request->get('role')
            ]);

            

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
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
        
        public function changePassword(Request $request) {
            $data = $request->all();
            $email = $request->route('email');
            $newPassword = Hash::make($data['newPassword']);
            $res = $this->userModel->returnUserInfo($email);
            if($res){
                if(strcmp($data['oldPassword'], $data['newPassword']) == 0){
                   return $this->sendError(ResponseMessage::PASSWORD_MUST_BE_DIFFERENT, ResponseCode::BAD_REQUEST);
                }
                $this->userModel->changePassword($email,$newPassword);
                if(!(Hash::check($data['oldPassword'], $res->password))){
                    return $this->sendError(ResponseMessage::PASSWORD_ERROR, ResponseCode::BAD_REQUEST);
                }else{
                    $result = $this->userModel->changePassword($email,$newPassword);
                    return $this->sendResponse($result, ResponseMessage::PASSWORD_CHANGED);
                }
                
                
                
            }
            return $this->sendError(ResponseMessage::USER_DOES_NOT_EXIST, ResponseCode::BAD_REQUEST);
        }

        public function update(Request $request) {
            $data = $request->all();
            $email = $request->route('email');
            $res = $this->userModel->update($email,$data);
            if($res){
                return $this->sendResponse($res, ResponseMessage::USER_INFO_UPDATED);
            }

            return $this->sendError(ResponseMessage::NO_CONTENT, ResponseCode::NO_CONTENT); 
        }

        public function viewProfile(Request $request) {
            $email = $request->route('email');
            $res = $this->userModel->returnUserInfo($email);
            if($res){
                return $this->sendResponse($res,[]);
            }

            return $this->sendError(ResponseMessage::NO_CONTENT, ResponseCode::NO_CONTENT); 
        }

}
