<?php

namespace App\Livewire\Pages\Auth;

use App\Livewire\Forms\LoginForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Session;
#[Layout('layouts.app')]
class Login extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
    public function loginWithGoogle()
    {
        return redirect()->route('socialite.redirect', ['provider' => 'google']);
    }

    public function loginWithGithub()
    {
        return redirect()->route('socialite.redirect', ['provider' => 'github']);
    }
    public function render()
    {
        return view('livewire.pages.auth.login');
    }
}
