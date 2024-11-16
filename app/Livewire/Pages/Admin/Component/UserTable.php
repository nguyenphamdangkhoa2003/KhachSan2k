<?php

namespace App\Livewire\Pages\Admin\Component;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Mary\Traits\Toast;
#[Layout('components.layouts.admin')]
class UserTable extends Component
{

    use Toast;
    use WithPagination;

    public $perPage = 5;
    public $id;
    #[Url(as: 'q')]
    public $search = "";
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    #[Rule(['photos' => 'required'])]          // A separated rule to make it required
    #[Rule(['photos.*' => 'image|max:1024'])]
    public array $photos = [];
    public array $photosDisplay = [];
    #[Layout("components.layouts.admin")]
    public function render()
    {
        $users = User::query()
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
        ;
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'is_admin', 'label' => 'Type'],
        ];
        return view('livewire.pages.admin.component.user-table', ["users" => $users, "headers" => $headers]);
    }
    public function paginationView()
    {
        return 'custom-paginator';
    }

}
