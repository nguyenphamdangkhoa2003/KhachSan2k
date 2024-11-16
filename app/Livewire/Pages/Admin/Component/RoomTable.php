<?php

namespace App\Livewire\Pages\Admin\Component;

use App\Models\RoomImage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;
use App\Models\RoomType;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Builder;
use App\Livewire\Forms\RoomForm;
use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Mary\Traits\Toast;
class RoomTable extends Component
{
    use Toast;
    use WithPagination;
    use WithFileUploads;
    use MediaAlly;
    public $perPage = 5;
    public $isEditing = false;
    public $isShowActionModal = false;
    public $isShowConfirmModal = false;
    public $id;
    #[Url(as: 'q')]
    public $search = "";
    public RoomForm $roomForm;
    public array $sortBy = ['column' => 'room_number', 'direction' => 'asc'];
    #[Rule(['photos' => 'required'])]          // A separated rule to make it required
    #[Rule(['photos.*' => 'image|max:1024'])]
    public array $photos = [];
    public array $photosDisplay = [];
    #[Layout("components.layouts.admin")]
    public function render()
    {
        $rooms = Room::query()
            ->when($this->search, fn(Builder $q) => $q->where('room_number', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
        ;
        $room_types = RoomType::all(['name', 'id']);
        $headers = [
            ['key' => 'room_number', 'label' => '#'],
            ['key' => 'area', 'label' => 'Area'],
            ['key' => 'quanlity', 'label' => 'Quanlity'],
            ['key' => 'room_type.name', 'label' => 'Room Type'],
            ['key' => 'description', 'label' => 'Description'],
            ['key' => 'status', 'label' => 'Status'],
        ];
        return view('livewire.pages.admin.component.room-table', ["rooms" => $rooms, "headers" => $headers, 'room_types' => $room_types]);
    }

    public function showEdit($id)
    {
        $this->id = $id;
        $this->isShowActionModal = true;
        $this->isEditing = true;

        $room = Room::find($id);
        $this->roomForm->room_number = $room->room_number;
        $this->roomForm->area = $room->area;
        $this->roomForm->quanlity = $room->quanlity;
        $this->roomForm->description = $room->description;
        $this->roomForm->status = $room->status;
        $this->roomForm->room_type_id = $room->room_type_id;

        foreach ($room->roomImage as $value) {
            array_push($this->photosDisplay, $value->url);
        }
    }
    public function showAdd()
    {
        $this->roomForm->reset();
        $this->isShowActionModal = true;
        $this->isEditing = false;
    }
    public function showConfirm($id)
    {
        $this->id = $id;
        $this->isShowConfirmModal = true;
    }
    public function delete()
    {
        DB::transaction(function () {
            $room = Room::find($this->id);
            $room_images = $room->roomImage;
            foreach ($room_images as $room_image) {
                Cloudinary::destroy($room_image->public_image_id);
            }
            Room::destroy($this->id);
        });
        $this->isShowConfirmModal = false;
        $this->success("Delete Successfully!", "The room type was deleted successfully", "toast-top toast-center");
    }
    public function save()
    {
        try {
            $this->roomForm->validate();

            DB::transaction(function () {
                // Tạo bản ghi trong bảng `rooms` và lấy ID của phòng
                $room = Room::create($this->roomForm->pull());

                // Lưu ảnh vào Cloudinary và lưu các URL
                foreach ($this->photos as $photo) {
                    $cloundinaryImage = cloudinary()->upload($photo->getRealPath());
                    RoomImage::create([
                        "room_id" => $room->id,
                        "url" => $cloundinaryImage->getSecurePath(),
                        "public_image_id" => $cloundinaryImage->getPublicId(),
                    ]);
                }
            });
            $this->isShowActionModal = false;
            $this->success("Create Successfully!", "The room was created successfully", "toast-top toast-center");
        } catch (\Throwable $th) {
            $this->error("Create Fail!", "The room was create fail", "toast-top toast-center");
        }


    }
    public function update()
    {
        DB::transaction(function () {
            $room = Room::find($this->id);
            $room->room_number = $this->roomForm->room_number;
            $room->area = $this->roomForm->area;
            $room->quanlity = $this->roomForm->quanlity;
            $room->description = $this->roomForm->description;
            $room->status = $this->roomForm->status;
            $room->room_type_id = $this->roomForm->room_type_id;
            $room->save();
            if (count($this->photos) > 0) {
                $room_images = $room->roomImage;
                foreach ($room_images as $room_image) {
                    Cloudinary::destroy($room_image->public_image_id);
                }
                foreach ($this->photos as $photo) {
                    $cloundinaryImage = cloudinary()->upload($photo->getRealPath());
                    RoomImage::create([
                        "room_id" => $room->id,
                        "url" => $cloundinaryImage->getSecurePath(),
                        "public_image_id" => $cloundinaryImage->getPublicId(),
                    ]);
                }
            }
        });

        $this->isShowActionModal = false;

        $this->success("Update Successfully!", "The room type was updated successfully", "toast-top toast-center");
    }
    public function paginationView()
    {
        return 'custom-paginator';
    }
}
