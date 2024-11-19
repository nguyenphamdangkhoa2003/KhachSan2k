<?php

namespace App\Livewire\Forms;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public $name;
    public $email;
    public $password;
    public $cpassword;
    public $phonenumber;
    public $dob;
    public $avatar;
    protected function rules()
    {
        return [
            "avatar" => "required|max:1024",
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|lowercase',
            'password' => ['required', 'string', Password::defaults()],
            'cpassword' => 'required|same:password',
            'phonenumber' => 'required|numeric|digits_between:10,15',
            'dob' => 'required|date|before:today',
        ];
    }
    protected function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'cpassword.required' => 'Confirm Password is required.',
            'cpassword.same' => 'Confirm Password must match the password.',
            'phonenumber.required' => 'Phone number is required.',
            'phonenumber.numeric' => 'Phone number must contain only numbers.',
            'phonenumber.digits_between' => 'Phone number must be between 10 and 15 digits.',
            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Please enter a valid date.',
            'dob.before' => 'Date of birth must be a date before today.',
            'address_id.required' => 'Address is required.',
            'address_id.exists' => 'Selected address does not exist.',
        ];
    }
}
