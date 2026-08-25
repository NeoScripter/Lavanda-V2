<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Enums\Locale;
use Enums\SessionKey;
use Exception;
use Http\Controller;
use Http\Models\AudioMessage;
use Http\Requests\CRUD\AudioMessage\StoreAudioMessageRequest;
use Http\Requests\CRUD\AudioMessage\UpdateAudioMessageRequest;
use Traits\RequiresAuth;

class AudioMessageController extends Controller
{
    use RequiresAuth;

    public function index(\Base $hive)
    {
        $page = $hive->GET['page'] ?? 1;
        $page = is_numeric($page) ? (int) $page : 1;
        $locale = Locale::normalize($hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value) ?? '');

        $audio = new AudioMessage();
        $audio = $audio->paginate(
            $page - 1,
            15,
            ['locale=?', $locale],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/audio_messages/index', [
            'title' => 'All audio_messages',
            'audios' => $audio,
        ]);
    }

    public function create()
    {
        view('pages/admin/audio_messages/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $audio = new AudioMessage();
        $audio->load(['id = ?', $id]);

        view('pages/admin/audio_messages/edit', [
            'title' => $audio->title,
            'audio' => $audio->cast(),
        ]);
    }

    public function show(\Base $hive)
    {

        $id = $hive->PARAMS['id'];
        $audio = new AudioMessage();
        $audio->load(['id = ?', $id]);

        view('pages/admin/audio_messages/show', [
            'title' => $audio->title,
            'audio' => $audio->cast(),
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreAudioMessageRequest::class);
        $request->validate();

        $audio = new AudioMessage();
        $audio->copyFrom($request->all());
        $audio->save();

        notify($hive->get('admin.audio_successfully_created'));

        $hive->reroute('@admin_audio_messages_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateAudioMessageRequest::class);
        $request->validate();

        $audio = new AudioMessage();
        $audio->load(['id = ?', $id]);

        if ($audio->dry()) {
            throw new Exception('AudioMessage not found');
        }

        $audio->copyFrom($request->all());
        $audio->save();

        notify($hive->get('admin.audio_successfully_updated'));

        $hive->reroute("@admin_audio_messages_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $audio = new AudioMessage();
        $audio->load(['id = ?', $id]);
        $audio->erase();

        notify($hive->get('admin.audio_successfully_deleted'));
        $hive->reroute("@admin_audio_messages_index");
    }
}
