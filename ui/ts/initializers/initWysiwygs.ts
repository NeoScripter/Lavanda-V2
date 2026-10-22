
export default async function initWysiwygs() {
    const editor = document.querySelector('[component-wysiwyg-editor]');

    if (!editor) return;

    const overtype = await import('../modules/wysiwygs');
    overtype .default();
}
