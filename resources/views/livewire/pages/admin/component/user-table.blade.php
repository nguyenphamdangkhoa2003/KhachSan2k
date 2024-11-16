<div>
    <x-mary-toast />
    <x-mary-header title="User" separator>
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" placeholder="Search..." wire:model.live="search" clearable />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button class="btn-primary" link="{{ route('admin.dashboard.user.create') }}" label="Add"
                icon-right="o-plus" spinner="link" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="$headers" :rows="$users" :sort-by="$sortBy" with-pagination striped>
        @scope('cell_id', $users)
            <strong>{{ $users->id }}</strong>
        @endscope

        @scope('cell_name', $users)
            <x-mary-avatar :image="$users->avatar" :title="$users->name" />
        @endscope

        @scope('cell_email', $users)
            <i>{{ $users->email }}</i>
        @endscope
        @scope('cell_is_admin', $users)
            @if ($users->is_admin == 1)
                <x-mary-badge class="badge-primary" value="Admin" />
            @else
                <x-mary-badge class="badge-secondary" value="User" />
            @endif
        @endscope
        <x-slot:empty>
            <x-mary-icon name="o-cube" label="It is empty." />
        </x-slot:empty>
    </x-mary-table>
</div>
