<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Exception;
use Support\Auth;
use Http\Controller;
use Http\Models\Program;
use Http\Requests\UpdateProgramRequest;
use Jobs\ProcessImageJob;

class ProgramController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function index()
    {
        $programs = new Program();
        $programs = $programs->find([], ['order' => 'title DESC']);

        view('pages/admin/programs/index', [
            'title' => 'All programs',
            'programs' => $programs,
        ]);
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $program = new Program();
        $program->load(['id = ?', $id]);

        view('pages/admin/programs/edit', [
            'title' => $program->title,
            'program' => $program,
        ]);
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateProgramRequest::class);
        $request->validate();

        $programs = new Program();
        $programs->load(['id = ?', $id]);

        if ($programs->dry()) {
            throw new Exception('Program not found');
        }

        $data = $request->all();
        unset($data['gallery']);
        $programs->copyFrom($data);
        $programs->save();
        $with_images = false;

        if (! $programs->dry() && $request->input('gallery')) {
            $with_images = true;
            ProcessImageJob::dispatch([
                'parent_id'      => $programs->id,
                'parent_class'   => Program::class,
                'field'          => 'gallery',
                'sizes'          => ['mb' => 350, 'dk' => 1000],
                'files'          => $request->input('gallery'),
            ]);
        }

        $message = 'Program successfully updated!';

        if ($with_images) {
            $message .= "\nPlease wait for 2-10 minutes in order to see updated image files";
        }

        notify($message);
        $hive->reroute("@admin_programs_edit(@id=$id)");
    }
}
