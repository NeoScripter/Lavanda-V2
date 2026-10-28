<?php
$hive = \Base::instance();

extract(component_props(
    required: ['plans'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.редактировать_профиль"),
    'class' => "bg-[url('/assets/images/pages/article/page-bg.webp')] bg-cover bg-center"
]); ?>

<section class='pt-(--pt-lg) full-bleed'>
    <div class="bg-white w-full max-w-120 lg:max-w-240 mx-auto xs:rounded-xl sm:rounded-primary px-6 py-9 sm:py-11 sm:px-9">

        <div class="flex flex-col gap-8">
            <h1 class="text-xl text-center font-semibold"><?= $hive->get("web.редактировать_профиль") ?>
            </h1>

            <div class='grid lg:grid-cols-2 gap-10 border-b border-primary/50 pb-10'>
                <article>
                    <h2 class="font-medium text-base text-left hyphens-auto"><?= $hive->get("web.обновить_профиль") ?>
                    </h2>

                    <form cmp-otp-form action="<?= \Base::instance()->alias('profile_update') ?>" method="post" class="space-y-6">
                        <?= csrf() ?>

                        <?= component('web/form/form-input', [
                            'name'  => 'name',
                            'label' => $hive->get("web.имя_пользователя"),
                            'error' => $errors['name'] ?? '',
                            'attrs' => [
                                'type'     => 'text',
                                'required' => true,
                            ],
                        ]) ?>

                        <?= component('web/form/form-input', [
                            'name'  => 'email',
                            'label' => $hive->get("web.электронная_почта"),
                            'error' => $errors['email'] ?? '',
                            'attrs' => [
                                'type'     => 'email',
                                'required' => true,
                            ],
                        ]) ?>

                        <div cmp-otp-input class='hidden'>
                            <?= component('web/form/form-input', [
                                'name'  => 'otp_code',
                                'label' => $hive->get("web.введите_код_подтверждения_отправленный_вам_на_электронную_почту"),
                                'error' => $errors['otp_code'] ?? '',
                                'attrs' => [
                                    'type'     => 'text',
                                    'required' => false,
                                ],
                            ]) ?>
                        </div>

                        <div class="flex justify-between gap-2.5">
                            <?php slot('components/web/ui/button', ['attrs' => ['type' => 'submit'], 'size' => 'sm']); ?>
                            <?= $hive->get('admin.save_password') ?>
                            <?php end_slot(); ?>
                        </div>
                    </form>

                </article>

                <article>
                    <h2 class="font-medium text-base text-left hyphens-auto"><?= $hive->get("web.сменить_пароль") ?>
                    </h2>

                    <form action="<?= \Base::instance()->alias('password_update') ?>" method="post" class="space-y-6">
                        <?= csrf() ?>

                        <?= component('web/form/form-input', [
                            'name'  => 'current_password',
                            'label' => $hive->get('admin.current_password'),
                            'error' => $errors['current_password'] ?? '',
                            'attrs' => [
                                'type'     => 'password',
                                'required' => true,
                                'value'    => $values['current_password'] ?? '',
                            ],
                        ]) ?>

                        <?= component('web/form/form-input', [
                            'name'  => 'password',
                            'label' => $hive->get('admin.password'),
                            'error' => $errors['password'] ?? '',
                            'attrs' => [
                                'type'     => 'password',
                                'required' => true,
                                'value'    => $values['password'] ?? '',
                            ],
                        ]) ?>

                        <?= component('web/form/form-input', [
                            'name'  => 'password_confirmation',
                            'label' => $hive->get('admin.confirm_password'),
                            'error' => $errors['password_confirmation'] ?? '',
                            'attrs' => [
                                'type'     => 'password',
                                'required' => true,
                                'value'    => $values['password_confirmation'] ?? '',
                            ],
                        ]) ?>

                        <div class="flex justify-between gap-2.5">
                            <?php slot('components/web/ui/button', ['attrs' => ['type' => 'submit'], 'size' => 'sm']); ?>
                            <?= $hive->get('admin.save_password') ?>
                            <?php end_slot(); ?>
                        </div>
                    </form>
                </article>
            </div>

            <dialog id="delete-profile-dialog" popover class='border border-primary p-4 rounded-sm relative max-w-80'>
                <p class='text-base'>
                    <?= $hive->get('web.вы_уверены_что_хотите_удалить_свой_аккаунт') ?>
                </p>
                <div class='flex items-center justify-center gap-6 mt-3'>
                    <form action="<?= $hive->alias('register_destroy') ?>" method="post">
                        <input type="hidden" name="_method" value="delete">
                        <?= csrf() ?>

                        <?= component('web/ui/button', [
                            'size' => 'sm',
                            'variant' => 'danger',
                            'slot' => $hive->get("web.удалить"),
                            'attrs' => ['type' => 'submit']
                        ]) ?>
                    </form>
                    <button popovertarget="delete-profile-dialog" popovertargetaction="hide" class='cursor-pointer min-w-25 transition-colors hover:text-primary'>
                        <span class='block size-6'><?= $hive->get("web.отмена") ?>
                        </span>
                    </button>
                </div>
            </dialog>
            <button popovertarget="delete-profile-dialog" class='flex text-foreground/80 mx-auto lg:ml-0 items-center justify-center gap-[0.5em]'>
                <span class='*:size-[1em]'> <?= svg('x') ?> </span>
                <?= $hive->get("web.удалить_аккаунт") ?>

            </button>
            <ul class='space-y-[0.5em] text-center order-2 lg:order-0'>
                <?php foreach ($plans as $plan) : ?>
                    <li class='text-primary font-bold'><?= $plan ?></li>

                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<?php end_slot(); ?>
