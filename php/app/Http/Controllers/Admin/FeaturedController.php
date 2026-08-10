<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Http\Models\Featured;
use Support\Auth;
use Http\Controller;
use Http\Requests\UpdateFeaturedRequest;
use Jobs\ProcessImageJob;

class FeaturedController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function show()
    {
        $feat = new Featured();
        $feat->load();

        view('pages/admin/featured', [
            'title' => 'Featured Section',
            'feat' => $feat,
        ]);
    }

    public function update(\Base $hive)
    {
        $request = $this->request(UpdateFeaturedRequest::class);
        $request->validate();

        $feat = new Featured();
        $feat->load();
        $data = $request->all();
        unset($data['image']);
        $feat->copyFrom($data);
        $feat->save();
        $with_image = false;

        if (! $feat->dry() && $request->input('image')) {
            $with_image = true;
            ProcessImageJob::dispatch([
                'parent_id'    => $feat->id,
                'parent_class' => Featured::class,
                'field'        => 'image',
                'dir'          => 'featured',
                'sizes'        => ['mb' => 540],
                'files'        => $request->input('image'),
                'qnt'          => 1,
            ]);
        }

        $message = 'Section successfully updated!';

        if ($with_image) {
            $message .= "\nPlease wait for 2-10 minutes in order to see updated image file";
        }

        notify($message);
        $hive->reroute('@featured');
    }
}
