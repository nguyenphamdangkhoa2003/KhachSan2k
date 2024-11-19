<?php

namespace App\Livewire\Admin\Component;

use App\Models\Carousel;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Mary\Traits\Toast;
#[Layout("components.layouts.admin")]
class CarouselTable extends Component
{
    use Toast;
    use WithFileUploads;
    #[Rule(['photos' => 'required'])]          // A separated rule to make it required
    #[Rule(['photos.*' => 'image|max:100'])]   // Notice `*` syntax for validate each file
    public array $photos = [];
    public function updatedPhotos()
    {
        foreach ($this->photos as $photo) {
            $cloundinary = cloudinary()->upload($photo->getRealPath());
            Carousel::create([
                "image" => $cloundinary->getSecurePath(),
                "public_image_id" => $cloundinary->getPublicId(),
            ]);
        }
        $this->photos = Carousel::all()->toArray();
        $this->success("Add Image", "Add image successfully", "toast-top toast-center");
    }
    public function delete($id)
    {
        try {
            $carousel = Carousel::find($id);
            Cloudinary::destroy($carousel->public_image_id);
            Carousel::destroy($id);
            $this->success("Delete Image", "Delete image successfully", "toast-top toast-center");
        } catch (\Throwable $th) {
            $this->error("Delete Image", "Delete image fail", "toast-top toast-center");
        }
    }
    public function render()
    {
        $this->photos = Carousel::all()->toArray();
        return view('livewire.admin.component.carousel-table');
    }
}
