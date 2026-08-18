<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Http\Controller;
use Http\Models\Image;
use Http\Requests\Card\UpdateImageRequest;
use Jobs\ProcessImageJob;
use Support\Auth;

class CardImageController extends Controller
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

        if ($img->dry()) {
            notify('Could not find an image with the provided id');
            $referrer = $hive->HEADERS['Referer'] ?? '/';
            $hive->reroute($referrer);
        }

        $img->alt = $request->input('alt');
        $img->save();

        if ($request->input('src')) {
            ProcessImageJob::dispatch([
                'imageable_id'      => $img->imageable_id,
                'imageable_type'   => $img->imageable_type,
                'variant'          => $img->variant,
                'sizes'          => ['mb' => 150, 'tb' => 250, 'dk' => 300],
                'files'          => $request->input('src'),
                'qnt'            => 1,
            ]);
        }

        notify($hive->get('admin.image_successfully_updated'));

        $referrer = $hive->HEADERS['Referer'] ?? '/';
        $hive->reroute($referrer);
    }
}
