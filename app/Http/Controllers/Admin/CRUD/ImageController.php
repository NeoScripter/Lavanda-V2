<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Http\Controller;
use Http\Models\Image;
use Http\Requests\CRUD\Image\UpdateImageRequest;
use Jobs\ProcessImageJob;
use Traits\RequiresAuth;

class ImageController extends Controller
{
    use RequiresAuth;

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

            $raw_file = $request->input('src');

            if (! empty($raw_file)) {
                $sizes = read_existing_variant_sizes($img->src);

                ProcessImageJob::dispatch([
                    'image_id' => $img->id,
                    'sizes' => $sizes,
                    'file' => $raw_file[0]['src']
                ]);
            }
            notify($hive->get('admin.image_successfully_updated'));
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
