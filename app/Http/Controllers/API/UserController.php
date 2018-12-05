<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    // use auth:api middleware for login
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('isAdmin');


        $user = User::paginate(4);
        $response = [
            'pagination' => [
                'total' => $user->total(),
                'per_page' => $user->perPage(),
                'current_page' => $user->currentPage(),
                'last_page' => $user->lastPage(),
                'from' => $user->firstItem(),
                'to' => $user->lastItem()
            ],
            'data' => $user
        ];
        return response()->json($response);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191|email|unique:users'.$request->id,
            'password' => 'required|string|min:6',
        ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => $request['type'],
            
        ]);
    }

    
    //Update Profile information
    
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            
        ]);

        
            if (strlen($request->photo) > 200) {
                
                $currentPhoto = $user->photo;
                if($request->photo != $currentPhoto){
                    // base64 to image intervention
                    // pattern 1
                    // $name = time().'.'.explode('/',explode(':',substr($request->photo, 0, 
                    // strpos($request->photo, ';')))[1])[1];
                    // pattern 2
                    $name = time().'.'.(explode('/', (explode(';', $request->photo))[0]))[1];
        
                    Image::make($request->photo)->save(public_path('image/profile/').$name);
        
                    $request->merge(['photo' => $name]);
                }
        
                $userPhoto = public_path('image/profile/').$currentPhoto;
                if(file_exists($userPhoto)){
                    // remove the image from local storage
                    @unlink($userPhoto);
                }
            }
        

        // update all requests
        $user->update($request->all());
        return ['message'=>'Profile Success'];

    }





    // change password
    public function changePassword(Request $request){

        $this->validate($request,[
            
            'current_password' => 'required|string|min:6',
            'new_password'  => 'required|string|min:6'
        ]);

        $user = auth('api')->user();
        $currentPassword = $user->password;
        if (!(Hash::check($request->get('current_password'), $currentPassword))) {
            // The passwords matches
            throw new \Exception("password didn't match");
        }else{
            // here code for update password
            $request->merge(['password' => Hash::make($request['new_password'])]);
            $user->update($request->all());
            return ["message" =>  "password  match"];
        }

 
        

    }
    
    public function profile()
    {
        return auth('api')->user();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $user = User::findOrFail($id);
        

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191|email|unique:users,email,'.$user->id,
        ]);

        $user -> update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');


        $user = User::findOrFail($id);
        $user -> delete();
        // return ["message" => "user deleted"];
    }
}
