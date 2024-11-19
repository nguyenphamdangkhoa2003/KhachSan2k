<div>


    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
            @foreach ($slides as $slide)
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="{{ $slide['image'] }}"
                        class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                </div>
            @endforeach
        </div>

    </div>

    <div class="flex justify-center">
        <x-mary-form class="w-full p-5 mt-4 bg-secondary shadow-md rounded-md" wire:submit="filter">
            <x-mary-header title="Check Booking Availability" size="text-xl" separator class="!mb-0" />
            <div class="flex justify-between">
                <x-mary-datetime label="Check-in" wire:model="myDate" icon="o-calendar" />
                <x-mary-datetime label="Check-out" wire:model="myDate" icon="o-calendar" />
                <x-mary-input label="Adult" wire:model="money2" type="number" min="0" />
                <x-mary-input label="Children" wire:model="money2" type="number" min="0" />
                <x-mary-button label="submit" class="btn-primary self-end" type="submit" spinner="filter" />
            </div>
        </x-mary-form>
    </div>
    <div class="mt-10">
        <h1 class="text-4xl font-medium text-center">Phòng của chúng tôi</h1>
        <div class="divider"></div>
        <div class="flex justify-between gap-3">
            @foreach ($type_rooms as $type_room)
                <x-mary-card title="{{ $type_room['name'] }}" class="shadow-md">
                    <div class="mt-3">
                        <div class="text-xl font-bold">Giá</div>
                        <i>{{ $type_room['price'] }} / đêm</i>
                    </div>
                    <div class="mt-3">
                        <div class="text-xl font-bold">Khách hàng</div>
                        <div class="flex">
                            <x-mary-badge value="{{ $type_room['adult'] }} Adult" />
                            <x-mary-badge value="{{ $type_room['children'] }} Children" />
                        </div>
                    </div>
                    <x-slot:figure>
                        @php
                            $images = array_column($type_room->TypeRoomImages->toArray(), 'url');
                            $images = array_map(function ($item) {
                                return ['image' => $item];
                            }, $images);
                        @endphp
                        <x-mary-carousel :slides="$images" without-indicators />
                    </x-slot:figure>
                    <x-slot:menu>
                        <x-mary-button icon="o-share" class="btn-circle btn-sm" />
                        <x-mary-icon name="o-heart" class="cursor-pointer" />
                    </x-slot:menu>
                    <x-slot:actions>
                        <x-mary-button label="Đặt phòng" class="btn-primary" />
                        <x-mary-button label="Thông tin thêm" class="btn-secondary" />
                    </x-slot:actions>
                </x-mary-card>
            @endforeach
        </div>
        <div class="flex justify-center">
            <x-mary-button label="Xem thêm >>" class="btn-outline mt-3" />
        </div>
    </div>
</div>
