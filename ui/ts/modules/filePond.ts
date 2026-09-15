import { defineFilePond } from 'filepond';
import { locale } from 'filepond/locales/en-gb';
import { qs } from '../utils';

export default function initFilePond() {
    const instances = defineFilePond({
        locale,
    });
    const updateLegend = (
        legend: HTMLLegendElement,
        altWrapper: HTMLOListElement
    ) => {
        if (altWrapper.children.length > 0) {
            legend.classList.remove('hidden');
        } else {
            legend.classList.add('hidden');
        }
    };

    for (const instance of instances) {
        instance.onchange = () => {
            const files = instance.currentEntries;

            const parent = instance.parentElement as HTMLDivElement;

            const imageWrapper = qs<HTMLUListElement>(
                '[component-file-grid]',
                'error',
                parent
            );

            const imageTemplate = qs<HTMLTemplateElement>(
                '[component-image-template]',
                'error',
                parent
            );

            const altWrapper = qs<HTMLOListElement>(
                '[component-file-alts]',
                'error',
                parent
            );

            const altTemplate = qs<HTMLTemplateElement>(
                '[component-alt-template]',
                'error',
                parent
            );

            const legend = qs<HTMLLegendElement>(
                '[component-legend]',
                'error',
                parent
            );

            imageWrapper.innerHTML = '';
            altWrapper.innerHTML = '';

            for (const file of files) {
                const imageClone = document.importNode(
                    imageTemplate.content,
                    true
                );
                const imgTag = imageClone.querySelector('img');

                if (!imgTag) continue;

                imgTag.src = URL.createObjectURL(file.src);

                imageWrapper.appendChild(imageClone);

                const altClone = document.importNode(altTemplate.content, true);
                const inputName = altWrapper.getAttribute('data-alt-name');

                if (!inputName) continue;

                const input = qs<HTMLInputElement>('input', 'error', altClone);
                input.setAttribute('name', inputName);

                altWrapper.appendChild(altClone);
            }

            updateLegend(legend, altWrapper);
        };
    }
}
