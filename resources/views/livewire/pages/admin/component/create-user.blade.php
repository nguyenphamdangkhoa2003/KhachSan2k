<div x-data="{
    province: null,
    province_id: null,
    district: null,
    district_id: null,
    ward: null,
    getProvince() {
        fetch('https://vapi.vnappmob.com/api/province').then((res) => res.json()).then((data) => {
            this.province = data.results;
        })
    },
    getDistrict() {
        fetch(`https://vapi.vnappmob.com/api/province/district/${this.province_id}`).then((res) => res.json()).then((data) => {
            this.district = data.results;
        })
    },
    getWard() {
        fetch(`https://vapi.vnappmob.com/api/province/ward/${this.district_id}`).then((res) => res.json()).then((data) => {
            this.ward = data.results;
        })
    }
}" x-init="getProvince()">

    <x-mary-header title="Create new user" separator progress-indicator="save" />
    <div class="grid lg:grid-cols-2 gap-5">
        <div>
            <x-mary-toast />
            <x-mary-form wire:submit.prevent="save">
                <x-mary-file wire:model="photo" label="Avatar">
                    <x-mary-avatar :image="$photo" class="!w-40 !rounded-lg" />
                </x-mary-file>
                <x-mary-input placeholder="Your name" icon="o-user" label="Name" wire:model="userForm.name" />
                <x-mary-input label="Email" wire:model="userForm.email" prefix="@" />
                <x-mary-input label="Phone number" class="join-item" prefix="+84" wire:model="userForm.phonenumber" />
                <x-mary-datepicker label="Date of birth" wire:model="userForm.dob" icon="o-calendar"
                    :config="$config" />
                <label class="pt-0 label label-text font-semibold">Address</label>
                <div class="join">
                    <select class="join-item select select-primary" x-model="province_id" wire:model="province"
                        x-on:change="getDistrict">
                        <template x-for="p in province">
                            <option x-text="p.province_name" :value="p.province_id" />
                        </template>
                    </select>
                    <select x-show="district" class="join-item select select-primary" x-model="district_id"
                        wire:model="district" x-on:change="getWard">
                        <template x-for="d in district">
                            <option x-text="d.district_name" :value="d.district_id" />
                        </template>
                    </select>
                    <select x-show="ward" class="join-item select select-primary" wire:model="ward">
                        <template x-for="d in ward" wire:model="ward">
                            <option x-text="d.ward_name" :value="d.ward_id" />
                        </template>
                    </select>
                </div>
                <x-mary-password wire:model="userForm.password" label="Password" hint="Password" clearable />
                <x-mary-password wire:model="userForm.cpassword" label="Confirm password" hint="Confirm Password"
                    clearable />
                <x-slot:actions>
                    <x-mary-button label="Cancel" />
                    <x-mary-button label="Save!" icon="" class="btn-primary" type="submit" spinner="save" />
                </x-slot:actions>

            </x-mary-form>
        </div>
        <x-svg.background class="flex justify-center items-center max-w-lg" />
    </div>
</div>
