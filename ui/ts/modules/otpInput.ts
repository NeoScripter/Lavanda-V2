import { qs } from '../utils';

export default function initOtpInput() {
    const otpForm = qs<HTMLFormElement>('[cmp-otp-form]', 'silent');

    if (!otpForm) return;

    const codeInputWrapper = qs<HTMLInputElement>(
        '[cmp-otp-input]',
        'error',
        otpForm
    );
    const emailInput = qs<HTMLInputElement>(
        'input[name="email"]',
        'error',
        otpForm
    );
    const nameInput = qs<HTMLInputElement>(
        'input[name="name"]',
        'error',
        otpForm
    );
    const codeInput = qs<HTMLInputElement>(
        'input[name="otp_code"]',
        'error',
        otpForm
    );

    const initialEmail = emailInput.value;
    let emailSent = false;

    otpForm.addEventListener('submit', async (e) => {
        const newEmail = emailInput.value;
        // TODO: add password mismatch trigger

        if (newEmail !== initialEmail) {
            codeInputWrapper.classList.remove('hidden');
            codeInput.setAttribute('required', 'true');

            if (emailSent === false) {
                e.preventDefault();

                try {
                    const response = await fetch('/api/verify_email', {
                        credentials: 'same-origin',
                        mode: 'same-origin',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                        },
                        body: JSON.stringify({
                            name: nameInput.value,
                            email: emailInput.value,
                        }),
                    });

                    if (!response.ok) {
                        console.error('Response failed:', response);
                    }
                    emailSent = true;
                } catch (error) {
                    console.error(error);
                }
            }
            return;
        }
    });

    emailInput.addEventListener('input', () => {
        const newEmail = emailInput.value;

        if (newEmail === initialEmail) {
            codeInputWrapper.classList.add('hidden');
            codeInput.removeAttribute('required');
        }
    });
}
