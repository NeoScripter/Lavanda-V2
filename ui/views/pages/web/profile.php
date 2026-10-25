<?php
$hive = \Base::instance();

extract(component_props(
    required: ['plans'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Редактировать профиль',
    'class' => "bg-[url('/assets/images/pages/article/page-bg.webp')] bg-cover bg-center"
]); ?>

<section class='pt-(--pt-lg) full-bleed'>
    <div class="bg-white w-full max-w-120 lg:max-w-240 mx-auto xs:rounded-xl sm:rounded-primary px-6 py-9 sm:py-11 sm:px-9">

        <div class="flex flex-col gap-8">
            <h1 class="text-xl text-center font-semibold">Редактировать профиль</h1>

            <div class='grid lg:grid-cols-2 gap-10 border-b border-primary/50 pb-10'>
                <article>
                    <h2 class="font-medium text-base text-left hyphens-auto">
                        Обновить профиль
                    </h2>

                    <form action="<?= \Base::instance()->alias('profile_update') ?>" method="post" class="space-y-6">
                        <?= csrf() ?>

                        <?= component('web/form/form-input', [
                            'name'  => 'name',
                            'label' => 'Имя пользователя',
                            'error' => $errors['name'] ?? '',
                            'attrs' => [
                                'type'     => 'text',
                                'required' => true,
                            ],
                        ]) ?>

                        <?= component('web/form/form-input', [
                            'name'  => 'email',
                            'label' => 'Электронная почта',
                            'error' => $errors['email'] ?? '',
                            'attrs' => [
                                'type'     => 'email',
                                'required' => true,
                            ],
                        ]) ?>


                        <div class="flex justify-between gap-2.5">
                            <?php slot('components/web/ui/button', ['attrs' => ['type' => 'submit'], 'size' => 'sm']); ?>
                            <?= $hive->get('admin.save_password') ?>
                            <?php end_slot(); ?>
                        </div>
                    </form>
                    <form action="<?= $hive->alias('email') ?>" method="post" class='mt-10'>
                        <button type="submit">Send an email</button>

                    </form>
                </article>

                <article>
                    <h2 class="font-medium text-base text-left hyphens-auto">
                        Сменить пароль
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
                            'name'  => 'new_password',
                            'label' => $hive->get('admin.new_password'),
                            'error' => $errors['new_password'] ?? '',
                            'attrs' => [
                                'type'     => 'password',
                                'required' => true,
                                'value'    => $values['new_password'] ?? '',
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

            <form action="<?= $hive->alias('register_destroy') ?>" method="post">
                <input type="hidden" name="_method" value="delete">
                <?= csrf() ?>

                <!-- TODO: Add a confirmation modal -->
                <button class='flex text-foreground/80 mx-auto lg:ml-0 items-center justify-center gap-[0.5em]'>
                    <span class='*:size-[1em]'> <?= svg('x') ?> </span>
                    Удалить аккаунт
                </button>
            </form>
            <ul class='space-y-[0.5em] text-center order-2 lg:order-0'>
                <?php foreach ($plans as $plan) : ?>
                    <li class='text-primary font-bold'><?= $plan ?></li>

                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<?php end_slot(); ?>
