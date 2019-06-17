<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'picture' => ['required', 'image', 'mimes:jpeg, png, jpg, gif', 'max:2048'],
        ], [], [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'picture' => 'プロフィール画像'
        ]);
    }

    protected function create(array $data)
    {
        $fileName = $this->saveProfileImage($data['picture']);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'picture_path' => $fileName,
        ]);
    }

    private function saveProfileImage($image)
    {
        // デフォルトではstorage/app/images/profilePictureに保存
        // ファイル名は自動で設定
        // php artisan storage:linkでシンボリックリンクを作成

        if (\App::environment('heroku')) {
            $imgPath = Storage::disk('s3')->putFile('images/profilePicture', $image, 'public');

            return Storage::disk('s3')->url($imgPath);
        }

        $imgPath = $image->store('images/profilePicture', 'public');

        return 'storage/' . $imgPath;
    }
}
