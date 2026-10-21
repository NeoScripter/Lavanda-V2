
<?php

use Enums\PlanSlug;

return [
    PlanSlug::ONE_TIME->value => [
        'image' => '/assets/images/pages/plans/plan-1/plan-1',
        'headline' => '3 вопроса - 3 ответа',
        'description' => 'Когда нужен ответ на то, что волнует прямо сейчас',
    ],
    PlanSlug::MONTHLY->value => [
        'image' => '/assets/images/pages/plans/plan-2/plan-2',
        'headline' => 'Неограниченное число обращений',
        'description' => 'В период, когда один разговор не решает все',
    ],
    PlanSlug::YEARLY->value => [
        'image' => '/assets/images/pages/plans/plan-3/plan-3',
        'headline' => 'Неограниченное число обращений',
        'description' => 'Когда хочется чтобы пространство для размышлений было рядом 365 дней в году',
    ],
    PlanSlug::PERSONAL->value => [
        'image' => '/assets/images/pages/plans/plan-4/plan-4',
        'headline' => 'Персональный разбор',
        'description' => 'Заполните форму, выберите формат и получите личный ответ от Lavanda на почту в течение 3 дней',
    ],
];
