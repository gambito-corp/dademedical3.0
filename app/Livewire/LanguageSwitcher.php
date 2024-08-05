<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageSwitcher extends Component
{
    public $languages = ['en', 'es'];
    public $currentLanguage;

    public function mount()
    {
        $this->currentLanguage = session('locale');
        App::setLocale($this->currentLanguage);
    }
    public function setLanguage($lang)
    {
        Session::put('locale', $lang);
        App::setLocale($lang);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
