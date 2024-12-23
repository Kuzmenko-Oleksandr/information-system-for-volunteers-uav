<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'unique_key' => [
                'nullable',
                'string',
                'exists:volunteer_unique_key,key',
                function ($attribute, $value, $fail) {
                    $volunteerKey = \DB::table('volunteer_unique_key')->where('key', $value)->first();
                    if ($volunteerKey && \App\Models\User::where('volunteer_unique_key_id', $volunteerKey->id)->exists()) {
                        $fail('This unique key is already used by another user.');
                    }
                },
            ],
        ]);
    }

    protected function create(array $data)
    {
        $volunteerKeyId = null;
        if (!empty($data['unique_key'])) {
            $volunteerKey = \DB::table('volunteer_unique_key')->where('key', $data['unique_key'])->first();
            if ($volunteerKey) {
                $volunteerKeyId = $volunteerKey->id;
            }
        }

        $role = $volunteerKeyId ? User::ROLE_VOLUNTEER : User::ROLE_READER;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'volunteer_unique_key_id' => $volunteerKeyId,
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
