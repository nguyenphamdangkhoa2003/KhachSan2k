<?php

namespace App\Livewire\Pages\Admin\Component;

use App\Livewire\Forms\RoomTypeForm;
use App\Models\RoomType;
use App\Models\TypeRoomImage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use PhpParser\Node\Stmt\TryCatch;
class RoomTypeTable extends Component
{
    use Toast;
    use WithPagination;
    use WithFileUploads;
    public $perPage = 5;
    public $isEditing = false;
    public $isShowActionModal = false;
    public $isShowConfirmModal = false;
    public $iShowFilterDrawer = false;
    public $photosUploaded = false;
    public $id;
    #[Url(as: 'q')]
    public $search = "";
    public RoomTypeForm $roomTypeForm;
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    #[Rule(['photos' => 'required'])]          // A separated rule to make it required
    #[Rule(['photos.*' => 'image|max:1024'])]
    public array $photos = [];
    public array $photosDisplay = [];
    #[Layout('components.layouts.admin')]
    public function render()
    {
        $type_rooms = RoomType::query()
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
        ;

        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Room Type'],
            ['key' => 'price', 'label' => 'Price'],
            ['key' => 'adult', 'label' => 'Adult'],
            ['key' => 'children', 'label' => 'Children'],
        ];
        return view('livewire.pages.admin.component.room-type-table', ["type_rooms" => $type_rooms, "headers" => $headers]);
    }

    public function showEdit($id)
    {
        $this->id = $id;
        $this->isShowActionModal = true;
        $this->isEditing = true;

        $typeRoom = RoomType::find($id);
        $this->roomTypeForm->name = $typeRoom->name;
        $this->roomTypeForm->price = $typeRoom->price;
        $this->roomTypeForm->children = $typeRoom->children;
        $this->roomTypeForm->adult = $typeRoom->adult;
        $this->roomTypeForm->description = $typeRoom->description;
    }
    public function showAdd()
    {
        $this->roomTypeForm->reset();
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


        try {
            $room_type = RoomType::find($this->id);
            $type_room_images = $room_type->TypeRoomImages;
            foreach ($type_room_images as $type_room_image) {
                Cloudinary::destroy($type_room_image->public_image_id);
            }
            RoomType::destroy($this->id);
            $this->isShowConfirmModal = false;
            $this->success("Delete Successfully!", "The room type was deleted successfully", "toast-top toast-center");
        } catch (\Throwable $th) {
            $this->error("Delete Fail", "The room type delete fail", "toast-top toast-center");
        }
    }
    public function save()
    {
        $this->roomTypeForm->validate();
        $room_type = RoomType::create($this->roomTypeForm->pull());
        $this->photosDisplay = [];
        foreach ($this->photos as $photo) {
            $cloundinaryImage = cloudinary()->upload($photo->getRealPath());
            TypeRoomImage::create([
                "room_type_id" => $room_type->id,
                "url" => $cloundinaryImage->getSecurePath(),
                "public_image_id" => $cloundinaryImage->getPublicId(),
            ]);
        }
        $this->isShowActionModal = false;
        $this->success("Create Successfully!", "The room type was created successfully", "toast-top toast-center");

    }
    public function update()
    {
        $typeRoom = RoomType::find($this->id);

        $typeRoom->name = $this->roomTypeForm->name;
        $typeRoom->price = $this->roomTypeForm->price;
        $typeRoom->children = $this->roomTypeForm->children;
        $typeRoom->adult = $this->roomTypeForm->adult;
        $typeRoom->description = $this->roomTypeForm->description;

        $typeRoom->save();

        if (count($this->photos) > 0) {
            $room_type_images = $typeRoom->TypeRoomImages;
            foreach ($room_type_images as $room_type_image) {
                Cloudinary::destroy($room_type_image->public_image_id);
            }
            foreach ($this->photos as $photo) {
                $cloundinaryImage = cloudinary()->upload($photo->getRealPath());
                TypeRoomImage::create([
                    "room_type_id" => $typeRoom->id,
                    "url" => $cloundinaryImage->getSecurePath(),
                    "public_image_id" => $cloundinaryImage->getPublicId(),
                ]);
            }
        }
        $this->photosDisplay = [];
        $this->isShowActionModal = false;

        $this->success("Update Successfully!", "The room type was updated successfully", "toast-top toast-center");
    }
    public function updatedPhotos()
    {
        // Cập nhật trạng thái khi ảnh được tải lên
        $this->photosDisplay = array_map(fn($photo) => $photo->temporaryUrl(), $this->photos);
        $this->photosUploaded = true;
    }
    public function paginationView()
    {
        return 'custom-paginator';
    }

}
