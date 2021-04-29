<?php

namespace App\Services;

use App\Models\Bulletin;
use App\Services\CoordinateService;
use App\Components\WorkWithImages;

class BulletinService
{
    public function __construct(CoordinateService $coordinateService)
    {
        $this->coordinateService = $coordinateService;   
    }
    public function getAll()
    {
        return Bulletin::select('id', 'title', 'description', 'image', 'created_at')
        ->where('valid_to', '>', date('Y-m-d'))->latest()->paginate(15);
    }

    public function getById($id)
    {
        return Bulletin::findOrFail($id);
    }

    public function getByIdWithCoordinate($id) 
    {
        return Bulletin::with('coordinate')->findOrFail($id);
    }

    public function store($req)
    {
        $data = $req->all();

        $data['user_id'] = auth()->guard('api')->user()->id;
        $data['image'] = $req->hasFile('image') ? WorkWithImages::upload($req->file('image')) : null;

        $bulletin = Bulletin::create($data);
        $data['bulletin_id'] = $bulletin ? $bulletin->id : null;

        $this->coordinateService->store($data);

        return $data['bulletin_id'];
    }

    public function update($req)
    {
        $data = $req->all();
        $id = $req['id'];

        $newImageName = $this->updateImage($id, $data, $req->hasFile('image') ? $req->file('image') : null);
        $data['image'] = $newImageName;

        Bulletin::find($id)->update($data);

        $this->coordinateService->update($id, $data);
    }

    private function updateImage($bulletinId, $data, $file)
    {
        $oldImageName = Bulletin::find($bulletinId)->image;
        if (isset($data['image'])) {
            if (is_string($data['image'])) {
                $newImageName = $oldImageName;
            } else {
                WorkWithImages::delete($oldImageName);
                $newImageName = WorkWithImages::upload($file);
                // if upload new image -> delete old image
            }
        } else {
            WorkWithImages::delete($oldImageName);
            $newImageName = null;
            // if exists old image -> delete old image
        }
        return $newImageName;
    }
}