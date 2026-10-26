import { qs } from '../utils';

export default function initPasswordConfirmationInput() {
    const confirmationInput = qs<HTMLInputElement>(
        'input[name="password_confirmation"]',
        'silent'
    );
    const passwordInput = qs<HTMLInputElement>(
        'input[name="password"]',
        'silent'
    );

    if (!confirmationInput || !passwordInput) return;

    passwordInput.addEventListener('input', () => {
        confirmationInput.setAttribute('pattern', passwordInput.value);
    });
}
