<div>
    <div>
        <x-mary-toast />
        <x-mary-header title="Room" subtitle="room in our hotel" separator>
            <x-slot:middle class="!justify-end">
                <x-mary-input icon="o-bolt" placeholder="Search..." wire:model.live="search" clearable />
            </x-slot:middle>
            <x-slot:actions>
                <x-mary-button class="btn-primary" wire:click="showAdd" label="Add" icon-right="o-plus"
                    spinner="showAdd" />
            </x-slot:actions>
        </x-mary-header>

        <x-mary-table :headers="$headers" :rows="$rooms" :sort-by="$sortBy" with-pagination striped>
            @scope('cell_room_number', $rooms)
                <strong>{{ $rooms->room_number }}</strong>
            @endscope

            @scope('cell_area', $rooms)
                <p>{{ $rooms->area }}</p>
            @endscope

            @scope('cell_quanlity', $rooms)
                <x-mary-rating total="{{ $rooms->quanlity }}" class="rating-xs" />
            @endscope
            @scope('cell_room_type.name', $rooms)
                <i>{{ $rooms->roomType->name }}</i>
            @endscope
            @scope('cell_description', $rooms)
                <p>{{ $rooms->description }}</p>
            @endscope

            @scope('cell_status', $rooms)
                @if ($rooms->status == 'available')
                    <x-mary-badge class="badge-primary" value="{{ $rooms->status }}" />
                @elseif ($rooms->status == 'booked')
                    <x-mary-badge class="badge-secondary" value="{{ $rooms->status }}" />
                @else
                    <x-mary-badge class="badge-warning" value="{{ $rooms->status }}" />
                @endif
            @endscope
            {{-- Special `actions` slot --}}
            @scope('actions', $rooms)
                <div class="flex">
                    <x-mary-button icon="o-trash" wire:click="showConfirm({{ $rooms->id }})"
                        spinner="showConfirm({{ $rooms->id }})" class="btn-sm" />
                    <x-mary-button icon="o-pencil-square" wire:click="showEdit({{ $rooms->id }})"
                        spinner="showEdit({{ $rooms->id }})" class="btn-sm" />
                </div>
            @endscope
            <x-slot:empty>
                <x-mary-icon name="o-cube" label="It is empty." />
            </x-slot:empty>
        </x-mary-table>
        <x-mary-modal wire:model="isShowActionModal" class="backdrop-blur">
            <x-mary-form wire:submit="{{ $isEditing ? 'update' : 'save' }}">
                <x-mary-header title="{{ $isEditing ? 'Update Room' : 'Create Room' }}" separator
                    progress-indicator="save" class="mb-0" />
                <x-mary-errors title="Oops!" description="Please, fix them." icon="o-face-frown" />
                <x-mary-input label="Room Number" wire:model="roomForm.room_number" placeholder="Type room number"
                    clearable />
                <x-mary-input type="number" label="Area" wire:model="roomForm.area" min="0" />
                <x-mary-input type="number" label="Quanlity" wire:model="roomForm.quanlity" min="0" />
                <x-mary-select label="Type Room" :options="$room_types" option-value="id" option-label="name"
                    placeholder="Select a type room" placeholder-value="0" hint="Select one, please."
                    wire:model="roomForm.room_type_id" />
                @php
                    $status = [
                        1 => ['value' => 'available', 'label' => 'Available'],
                        2 => ['value' => 'booked', 'label' => 'Booked'],
                        3 => ['value' => 'fixing', 'label' => 'Fixing'],
                    ];
                @endphp
                <x-mary-select label="Status" :options="$status" option-value="value" option-label="label"
                    placeholder="status--" placeholder-value="0" hint="Select one, please."
                    wire:model="roomForm.status" />
                <x-mary-textarea label="Description" wire:model="roomForm.description" placeholder="..."
                    hint="Max 1000 chars" rows="3" inline resize="false" />
                <div wire:key="user-{{ Auth::user()->id }}">
                    <x-mary-file wire:model.living="photos" label="Images" multiple class="mb-3" />
                    @if ($isEditing)
                        <x-mary-image-gallery :images="$photosDisplay" class="h-40 rounded-box" />
                    @else
                        <x-mary-image-gallery :images="array_map(fn($value) => $value->temporaryUrl(), $photos)" class="h-40 rounded-box" />
                    @endif
                </div>
                <x-slot:actions>
                    <x-mary-button label="Cancel" @click="$wire.isShowActionModal = false" />
                    <x-mary-button icon-right="{{ $isEditing ? 'c-arrow-up' : 'o-plus' }}"
                        label="{{ $isEditing ? 'Update' : 'Save' }}" class="btn-primary" type="submit"
                        spinner="{{ $isEditing ? 'update' : 'save' }}" />
                </x-slot:actions>
            </x-mary-form>
        </x-mary-modal>

        {{-- Modal confirm --}}
        <x-mary-modal wire:model="isShowConfirmModal" title="Are you sure?" separator>
            <div class="flex items-center gap-3">
                <svg height="100px" width="100px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                    fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <path style="fill:#EDA23F;"
                                d="M255.965,344.274c13.891,0,25.152,11.26,25.152,25.15c0,13.892-11.261,25.151-25.152,25.151 c-13.891,0-25.152-11.26-25.152-25.151C230.811,355.533,242.073,344.274,255.965,344.274L255.965,344.274z M410.036,212.702 L333.399,79.967c-7.279-14.681-18.799-27.459-34.041-36.281c-41.26-23.889-94.097-9.813-117.989,31.444l-79.385,137.489 l0.152,0.083l-0.152,0.256L26.767,343.254c-10.069,14.148-15.997,31.444-15.997,50.14c0,47.801,38.751,86.555,86.552,86.555 h158.764h158.767v-0.206c14.708,0.019,29.624-3.731,43.27-11.633c41.257-23.889,55.334-76.729,31.443-117.986L410.18,212.62 L410.036,212.702L410.036,212.702z M281.116,168.577v108.75c0,13.837-11.317,25.151-25.155,25.151 c-13.836,0-25.151-11.315-25.151-25.151v-108.75c0-13.837,11.316-25.151,25.152-25.151 C269.801,143.427,281.116,154.74,281.116,168.577z">
                            </path>
                            <g>
                                <circle style="fill:#565164;" cx="255.962" cy="369.42" r="25.152"></circle>
                                <path style="fill:#565164;"
                                    d="M255.963,302.479c13.838,0,25.155-11.315,25.155-25.151V168.577 c0-13.837-11.317-25.151-25.152-25.151c-13.838,0-25.152,11.314-25.152,25.151v108.75 C230.811,291.164,242.127,302.479,255.963,302.479z">
                                </path>
                            </g>
                        </g>
                        <g>
                            <path style="fill:#000003;"
                                d="M498.892,344.739l-79.386-137.504c-0.322-0.558-0.687-1.076-1.088-1.553L342.891,74.868 c-8.492-16.974-21.672-30.973-38.135-40.503c-14.783-8.56-31.583-13.084-48.582-13.084c-34.582,0-66.817,18.566-84.129,48.463 l-79.387,137.49c-0.321,0.557-0.59,1.137-0.804,1.733L17.689,337.439C6.115,353.886,0,373.221,0,393.394 c0,53.665,43.659,97.325,97.322,97.325h317.531c0.761,0,1.505-0.079,2.222-0.229c16.263-0.359,32.278-4.855,46.445-13.059 c22.444-12.995,38.482-33.958,45.164-59.026C515.361,393.336,511.884,367.17,498.892,344.739z M487.868,412.857 c-5.198,19.509-17.679,35.822-35.142,45.934c-11.504,6.662-24.562,10.184-37.86,10.184c-0.711,0.004-1.419,0.069-2.111,0.206 H97.322c-41.787,0-75.783-33.998-75.783-75.786c0-15.845,4.842-31.024,14.003-43.895c0.198-0.278,0.381-0.565,0.554-0.861 l75.189-130.248l0.121-0.206c0.349-0.59,0.639-1.209,0.868-1.845L190.69,80.527c13.468-23.258,38.561-37.706,65.484-37.706 c13.214,0,26.281,3.523,37.791,10.186c12.889,7.46,23.188,18.438,29.787,31.745c0.101,0.204,0.208,0.404,0.322,0.601 l76.638,132.737c0.322,0.558,0.687,1.076,1.088,1.554l78.449,135.879C490.361,372.985,493.067,393.348,487.868,412.857z">
                            </path>
                            <path style="fill:#000003;"
                                d="M167.012,186.926c-5.141-2.99-11.734-1.247-14.723,3.896L83.633,308.887 c-2.989,5.141-1.245,11.733,3.896,14.723c1.703,0.991,3.566,1.461,5.404,1.461c3.709,0,7.321-1.919,9.319-5.358l68.656-118.064 C173.898,196.508,172.155,189.916,167.012,186.926z">
                            </path>
                            <path style="fill:#000003;"
                                d="M83.413,330.662c-5.146-2.984-11.735-1.232-14.719,3.915l-0.254,0.438 c-2.983,5.146-1.231,11.736,3.915,14.719c1.702,0.985,3.559,1.454,5.393,1.454c3.714,0,7.329-1.925,9.326-5.369l0.253-0.438 C90.311,340.235,88.559,333.645,83.413,330.662z">
                            </path>
                            <path style="fill:#000003;"
                                d="M407.796,426.312c-51.358-0.063-62.716-0.037-78.437,0l-2.665,0.005 c-5.948,0.014-10.759,4.846-10.746,10.793c0.014,5.941,4.832,10.746,10.769,10.746c0.009,0,0.017,0,0.025,0l2.668-0.006 c15.698-0.036,27.04-0.063,78.36,0c0.005,0,0.01,0,0.015,0c5.941,0,10.761-4.814,10.769-10.757 C418.559,431.148,413.743,426.32,407.796,426.312z">
                            </path>
                            <path style="fill:#000003;"
                                d="M431.309,421.911l-0.236,0.137c-5.21,2.868-7.111,9.417-4.243,14.627 c1.96,3.565,5.643,5.58,9.445,5.58c1.754,0,3.534-0.43,5.181-1.335c0.246-0.136,0.493-0.279,0.739-0.423 c5.133-3.006,6.856-9.604,3.849-14.736C443.038,420.629,436.44,418.905,431.309,421.911z">
                            </path>
                            <path style="fill:#000003;"
                                d="M255.965,313.249c19.807,0,35.922-16.114,35.922-35.921V168.577 c0-19.806-16.116-35.921-35.924-35.921c-19.808,0-35.921,16.114-35.921,35.921v108.75 C220.042,297.135,236.157,313.249,255.965,313.249z M241.581,168.577c0-7.93,6.452-14.382,14.383-14.382 c7.93,0,14.383,6.451,14.383,14.382v108.75c0,7.93-6.452,14.382-14.383,14.382h-0.002c-7.93,0-14.382-6.452-14.382-14.382v-108.75 H241.581z">
                            </path>
                            <path style="fill:#000003;"
                                d="M255.965,333.502c-19.808,0-35.921,16.115-35.921,35.923c0,19.807,16.114,35.921,35.921,35.921 c19.809,0,35.923-16.114,35.923-35.921C291.888,349.616,275.772,333.502,255.965,333.502z M255.965,383.807 c-7.93,0-14.382-6.452-14.382-14.382c0-7.931,6.451-14.384,14.382-14.384s14.384,6.453,14.384,14.384 C270.349,377.355,263.896,383.807,255.965,383.807z">
                            </path>
                        </g>
                    </g>
                </svg>
                <p>Are you sure you want to proceed with this action? This action cannot be undone.</p>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.isShowConfirmModal = false" />
                <x-mary-button label="Confirm" class="btn-primary" wire:click="delete" spinner="delete" />
            </x-slot:actions>
        </x-mary-modal>
    </div>
</div>