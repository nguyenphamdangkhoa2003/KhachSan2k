<div>
    <x-mary-toast />
    <x-mary-file wire:model="photos" multiple />
    @if (count($photos) > 0)
        <span class="loading loading-dots loading-lg mt-5" wire:loading wire:target="photos"></span>
        <div class="flex flex-wrap mt-3 gap-3" wire:loading.class="hidden" wire:target="photos">
            @foreach ($photos as $photo)
                <div class="card bg-base-100 image-full w-[30%] h-96 shadow-xl" wire:key="{{ $photo['id'] }}">
                    <figure>
                        <img src="{{ $photo['image'] }}" alt="Shoes" class="w-full" />
                    </figure>
                    <div class="card-body">
                        <div class="card-actions items-end justify-end h-full">
                            <x-mary-button class="btn-error" icon="o-trash"
                                wire:click="delete({{ $photo['id'] }})" spinner="delete"></x-mary-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
