<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        // TASK: turn this SQL query into Eloquent
        // select * from users
        //   where email_verified_at is not null
        //   order by created_at desc
        //   limit 3

        $users = User::whereNotNull('email_verified_at')
                    ->orderByDesc('created_at')
                    ->limit(3)
                    ->get();

        return view('users.index', compact('users'));
    }

    public function show($userId)
    {
        try {
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return view('users.show', compact('user'));
    }

    public function check_create($name, $email)
    {
        // TASK: find a user by $name and $email
        $user = User::where('name', $name)->where('email', $email)->first();

        //   if not found, create a user with $name, $email and random password

        // Цей код повинен був також спрацювати
        // if (!$user) {
        //     $password = Str::random(8);
        //     $setUserData = [
        //         'name' => $name,
        //         'email' => $email,
        //         'password' => bcrypt($password),
        //         'email_verified_at' => now(),
        //     ];
        //     User::create($setUserData);
        // }

        if (!$user) {
            $password = Str::random(8); // Генерувати випадковий пароль
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'email_verified_at' => now(), // Позначаємо, що електронна адреса підтверджена
            ]);
        }

        return view('users.show', compact('user'));
    }

    public function check_update($name, $email)
    {
        // TASK: find a user by $name and update it with $email
        //   if not found, create a user with $name, $email and random password
        // updated or created user

        $user = User::where('name', $name)->first();

        if ($user) {
            $user->update(['email' => $email]);
        } else {
            $password = Str::random(8);

            // Знову ж таки повинно було працювати

            // $setUserData = [
            //     'name' => $name,
            //     'email' => $email,
            //     'password' => bcrypt($password),
            //     'email_verified_at' => now(),
            // ];
            // User::create($setUserData);

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'email_verified_at' => now(),
            ]);
        }

        return view('users.show', compact('user'));
    }

    public function destroy(Request $request)
    {
        // TASK: delete multiple users by their IDs
        // SQL: delete from users where id in ($request->users)
        // $request->users is an array of IDs, ex. [1, 2, 3]

        // Insert Eloquent statement here

        if ($request->has('users') && is_array($request->users)) {
            User::whereIn('id', $request->users)->delete();
        }

        return redirect('/')->with('success', 'Users deleted');
    }

    public function only_active()
    {
        // TASK: That "active()" doesn't exist at the moment.
        //   Create this scope to filter "where email_verified_at is not null"
        $users = User::active()->get();

        return view('users.index', compact('users'));
    }

}
