<?php

namespace Enums;

enum LegalSlug: string
{
    case CONSENT = 'user_agreement';
    case POLICY = 'privacy_policy';

    public function getLabel(): string
    {
        return \Base::instance()->get("admin.$this->value");
    }
}
