<?php

namespace App\Livewire\Pages\Admin\Component;

use App\Livewire\Forms\UserForm;
use App\Models\Address;
use App\Models\User;
use DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
#[Layout('components.layouts.admin')]
class CreateUser extends Component
{
    use Toast;
    use WithFileUploads;
    #[Rule("required|max:1024")]
    public $photo = 'https://res.cloudinary.com/dff6pkxpt/image/upload/v1731163431/9334243_ypl50f.jpg';
    public $province;
    public $district;
    public $ward;
    public $config = ['altFormat' => 'd/m/Y'];
    public UserForm $userForm;
    public function render()
    {
        return view('livewire.pages.admin.component.create-user');
    }
    public function save()
    {
        $this->validate();
        $address = Address::create([
            "province" => $this->province,
            "district" => $this->district,
            "ward" => $this->ward,
        ]);
        $user = User::create([
            "name" => $this->userForm->name,
            // "avatar" => null,
            "email" => $this->userForm->email,
            "phonenumber" => $this->userForm->phonenumber,
            "dob" => $this->userForm->dob,
            "password" => $this->userForm->password,
            "address_id" => $address->id
        ]);
        $this->userForm->reset();
        $this->success("Successfully", "Created a new user");
        // try {
        //     $this->userForm->validate();
        //     DB::transaction(function () {
        //         $address = Address::create([
        //             "province" => $this->province,
        //             "district" => $this->district,
        //             "ward" => $this->ward,
        //         ]);

        //         User::create($this->userForm->pull());
        //     });
        //     $this->success("Successfully", "Created a new user");
        // } catch (\Throwable $th) {
        //     $this->error("Error", "Created user faild");
        // }
    }
}
