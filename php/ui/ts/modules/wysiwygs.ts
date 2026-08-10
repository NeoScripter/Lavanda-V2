import OverType from 'overtype';

export default function initWysiwygs() {
    const editor = document.querySelector('[component-wysiwyg-editor]');

    if (!editor) return;

    const editors = OverType.init('[component-wysiwyg-editor]', {
        toolbar: true,
        theme: {
            name: 'my-theme',
            colors: {
                bgPrimary: 'var(--background)',
                bgSecondary: 'var(--background)',
                text: 'var(--foreground)',
                h1: 'var(--foreground)',
                h2: 'var(--foreground)',
                h3: 'var(--foreground)',
                strong: 'var(--foreground)',
                em: 'var(--foreground)',
                link: '#4169e1',
                code: 'var(--background)',
                codeBg: 'var(--accent-foreground)',
                blockquote: 'var(--foreground)',
                hr: 'var(--foreground)',
                syntaxMarker: 'var(--foreground)',
                cursor: 'var(--foreground)',
                selection: 'var(--accent-foreground)',
            },
        },
    });

    editors.forEach((editor) => {
        const element = editor.element;
        for (const attr of element.attributes) {
            if (attr.nodeValue && attr.nodeName.startsWith('data')) {
                editor.textarea.setAttribute(
                    attr.nodeName.replace('data-', ''),
                    attr.nodeValue
                );
            }
        }
    });
}
