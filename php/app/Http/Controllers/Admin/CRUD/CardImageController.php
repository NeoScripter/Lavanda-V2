<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Http\Controller;
use Http\Models\Image;
use Http\Requests\CRUD\Card\UpdateImageRequest;
use Jobs\ProcessImageJob;
use Traits\RequiresAuth;

class CardImageController extends Controller
{
    use RequiresAuth;

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

        notify("{$hive->get('admin.card_successfully_created')}! \n
            {$hive->get('admin.please_wait_for_1-2_minutes_in_order_to_see_updated_image_files')}");

        $referrer = $hive->HEADERS['Referer'] ?? '/';
        $hive->reroute($referrer);
    }
}
