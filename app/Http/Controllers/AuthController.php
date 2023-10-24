<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api');
        $this->middleware('JWT', ['except' => ['login','signup','me']]);
    }
    //, ['except' => ['login','signup']]
    /**
     * Get a JWT via given credentials.
     *
      * @return \Illuminate\Http\JsonResponse
     */
    public function login2(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['username', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or Password Invalid'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
    

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
            'email' => auth()->user()->email,
            'type' => auth()->user()->type,
        ]);
    }

    public function signup(Request $request){
        $validateData = $request->validate([
            'email' => 'required|unique:users|max:255',
            'name' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        DB::table('users')->insert($data);

        return $this->login($request);
    }

    public function login(Request $request)
{
   

	$this->validate($request, [
		'username' => 'required',
		'password' => 'required'
	]);


	$username = $request->input('username');
	$password = $request->input('password');

	$adServer = "192.168.70.81"; //"ldap://dpotmh.local";
	$ldap = ldap_connect($adServer, 389);

	$ldaprdn = "DPOTMH" . "\\" .$username;

	ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

	$bind = @ldap_bind($ldap, $ldaprdn, $password);

    $credentials = request(['username', 'password']);
	if($bind) {
		//get local db data
        $checkUser = User::where(["username"=>$request->username])->first();
        if (!$checkUser) {  

            $idno = $request->username;
            $ldap_users = array(
				'ftfuentes'=>'006240',
				'cfgarcia' =>'006237',
				'rcmoncatar' => '006342',
				'rmpesca' => '006369',	
				'jclucasan' => '006563',
			);

            if(array_key_exists($idno, $ldap_users)) {
                $idno =  $ldap_users[$idno];
            }
            
            $communicator_data = DB::connection('communicator')->select("select u.*, d.department_name from users u left join 
            department d on u.department = d.department_id where u.id_number = '$idno'");
                $user = new User;
                $user->name = ucwords($communicator_data[0]->firstname.' '.$communicator_data[0]->lastname);
                $user->email = $request->username.'@rivermedcenter.com';
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                $user->save();
                $token = auth()->attempt($credentials);
        }else{
            $token = auth()->attempt($credentials);
        }
			@ldap_close($ldap);
            return $this->respondWithToken($token);			
		}
		
     else {
		@ldap_close($ldap);
		return redirect('/')->with('error','Invalid Username and Password Combination');
	}

}
}