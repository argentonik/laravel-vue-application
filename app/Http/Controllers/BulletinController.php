<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BulletinRequest;
use App\Services\BulletinService;
use App\Components\Formatting;
use App\Models\Bulletin;

class BulletinController extends Controller
{
    public function __construct(Bulletin $bulletin, BulletinService $bulletinService)
    {
        $this->bulletin = $bulletin;
        $this->bulletinService = $bulletinService;
    }

    public function index()
    {
        $bulletins = $this->bulletinService->getAll();
        foreach($bulletins as $bulletin)
        {
            $bulletin->image =  Formatting::formatImagePath($bulletin->image);
            $bulletin->description = Formatting::formatDescriptionLength($bulletin->description);
            $bulletin->date = Formatting::formatDate($bulletin->created_at);
        }
        return $bulletins;
    }

    public function show(Request $req)
    {
        $bulletin = $this->bulletinService->getById($req->route('id'));

        $bulletin->image = Formatting::formatImagePath($bulletin->image);
        $bulletin->date = Formatting::formatDate($bulletin->created_at);
        $bulletin['latitude'] = optional($bulletin->coordinate)->latitude;
        $bulletin['longitude'] = optional($bulletin->coordinate)->longitude;

        return [
            'bulletin' => $bulletin
        ];
    }

    public function create()
    {
        $bulletin = $this->bulletin;
        $create = true;

        return [
            'id' => $bulletin->id,
            'create' => $create
        ];
    }

    public function edit(Request $req)
    {
        $id = $req->route('id');
        $bulletin = $this->bulletinService->getById($id);
        $bulletin->image = $bulletin->image ? Formatting::formatImagePath($bulletin->image) : null;
        
        $edit = true;
        $user = auth()->user();

        return [
            'bulletin' => $bulletin,
            'user' => $user
        ];
    }

    public function update(BulletinRequest $req)
    {
        $id = $req['id'];
        $preparedImage = $this->prepareImageFromView($id);

        $req['image'] = $preparedImage ? $preparedImage : $req['image'];

        $this->bulletinService->update($req);

        return [
            'req' => 'Message'
        ];
    }

    public function store(BulletinRequest $req)
    {
        $id = $this->bulletinService->store($req);

        return [
            'id' => $id
        ];
    }

    private function prepareImageFromView($bulletinId)
    {
        $oldBulletin = $this->bulletinService->getByIdWithCoordinate($bulletinId);
        $imageFromService = $oldBulletin->image;

        // prepare info about image
        if (!isset($_COOKIE['deletedServerImage']) && $imageFromService) {
            return $imageFromService;
        } else {
            unset($_COOKIE['deletedServerImage']);
            setcookie('deletedServerImage', "", time()-3600, '/');
        }
        return null;
    }
}
