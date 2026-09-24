import { qs } from '../utils';

export default function initPracticeItems() {
    const template = qs<HTMLTemplateElement>(
        '[component-pic-template]',
        'silent'
    );
    const grid = qs<HTMLUListElement>(
        '[component-practice-grid]',
        'silent'
    );
}
