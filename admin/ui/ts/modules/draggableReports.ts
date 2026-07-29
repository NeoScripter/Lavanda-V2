import { qsa, qs } from '../utils';

export default function initDraggableReports() {
    const draggableReports = qsa<HTMLLIElement>('[component-draggable-report]');

    for (const report of draggableReports) {
        report.addEventListener('dragstart', (e: DragEvent) => {
            e.dataTransfer!.setData('text/plain', e.currentTarget.id);
        });

        report.addEventListener('dragover', (e: DragEvent) => {
            e.preventDefault();
            e.stopPropagation();

            const draggedId = e.dataTransfer!.getData('text/plain');
            const targetId = (e.currentTarget as HTMLElement).id;

            if (draggedId === targetId) return;

            const target = e.currentTarget as HTMLElement;
            target.classList.add(
                'scale-103',
                'shadow-md',
                'border-dashed',
                'border-red-500',
                'border-2'
            );
            target.classList.remove('border');
        });

        report.addEventListener('dragleave', (e: DragEvent) => {
            e.preventDefault();
            e.stopPropagation();

            const target = e.currentTarget as HTMLElement;
            target.classList.remove(
                'scale-103',
                'shadow-md',
                'border-dashed',
                'border-red-500',
                'border-2'
            );
            target.classList.add('border');
        });

        report.addEventListener('dragenter', (e: DragEvent) => {
            e.preventDefault();
            e.stopPropagation();
        });

        report.addEventListener('drop', (e: DragEvent) => {
            e.preventDefault();
            e.stopPropagation();

            const draggedId = e.dataTransfer!.getData('text/plain');
            const targetId = (e.currentTarget as HTMLElement).id;

            if (draggedId === targetId) return;

            const template = qs<HTMLTemplateElement>(
                'template',
                'error',
                report
            );
            const clone = document.importNode(template.content, true);
            const form = qs<HTMLFormElement>('form', 'error', clone);

            const draggedInput = qs<HTMLInputElement>(
                'input[name=dragged_id]',
                'error',
                form
            );
            const targetInput = qs<HTMLInputElement>(
                'input[name=target_id]',
                'error',
                form
            );

            draggedInput.value = draggedId.replace('report_', '');
            targetInput.value = targetId.replace('report_', '');

            document.body.appendChild(form);
            form.submit();
        });
    }
}
