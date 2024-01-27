<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Hash;
use App\Models\User;

class LoginRegister extends Component
{
    public $users, $email, $password, $name;
    public $registerForm = false;

    public function render()
    {
        return view('livewire.login-register');
    }

    private function resetInputFields() {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->users = '';
    }

    public function login() {
        $validatedDate = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(\Auth::attempt(array('email' => $this->email, 'password' => $this->password))){
            session()->flash('message', "You are Logged.");
        }else{
            session()->flash('error', 'email and password are wrong.');
        }
        // dd($validatedDate);
        return redirect()->to('/travel');
    }

    public function register()
    {
        $this->registerForm = !$this->registerForm;
    }

    public function registerStore()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $this->password = Hash::make($this->password);

        User::create(['name' => $this->name, 'email' => $this->email,'password' => $this->password]);

        session()->flash('message', 'Your registered, You will be redirect to home page.');

        $this->resetInputFields();

    }
}
