<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Http\Controller;
use Http\Models\Image;
use Http\Requests\CRUD\UpdateImageRequest;
use Support\Auth;

class ImageController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
            exit;
        }
    }

    public function update(\Base $hive)
    {
        $request = $this->request(UpdateImageRequest::class);
        $request->validate();

        $id = $hive->PARAMS['id'];
        $img = new Image();
        $img->load(['id = ?', $id]);

        if (!$img->dry()) {
            $img->alt = $request->input('alt');
            $img->save();
            notify($hive->get('admin.image_successfully_updated!'));
        }

        $referrer = $hive->HEADERS['Referer'] ?? '/';
        $hive->reroute($referrer);
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $img = new Image();
        $img->load(['id = ?', $id]);

        if (!$img->dry()) {
            $img->erase();
            notify('Image successfully deleted');
        }

        $referrer = $hive->HEADERS['Referer'] ?? '/';
        $hive->reroute($referrer);
    }
}
