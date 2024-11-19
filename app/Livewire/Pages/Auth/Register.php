<?php

namespace App\Livewire\Pages\Auth;

use App\Livewire\Forms\UserForm;
use App\Models\Address;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
#[Layout('layouts.app')]
class Register extends Component
{
    use Toast;
    use WithFileUploads;
    #[Rule('required|max:1024')]
    public $photo = 'https://res.cloudinary.com/dff6pkxpt/image/upload/v1731163431/9334243_ypl50f.jpg';
    public $province;
    public $district;
    public $ward;
    public $config = ['altFormat' => 'd/m/Y'];
    public UserForm $userForm;
    public function register()
    {
        try {
            DB::transaction(function () {
                $this->userForm->validate();
                $address = Address::create([
                    'province' => $this->province,
                    'district' => $this->district,
                    'ward' => $this->ward,
                ]);
                $cloundinaryImage = cloudinary()->upload($this->userForm->avatar->getRealPath());
                $user = User::create([
                    'name' => $this->userForm->name,
                    'avatar' => $cloundinaryImage->getSecurePath(),
                    'email' => $this->userForm->email,
                    'phonenumber' => $this->userForm->phonenumber,
                    'dob' => $this->userForm->dob,
                    'password' => Hash::make($this->userForm->password),
                    'address_id' => $address->id,
                ]);
                event(new Registered($user));
                Auth::login($user);
                $this->success('Successfully', 'Created a new user');
            });
            $this->success('Successfully', 'Created a new user');
        } catch (\Throwable $th) {
            $this->error('Error', 'Created user faild');
        }
    }
    public function render()
    {
        return view('livewire.pages.auth.register');
    }
}
