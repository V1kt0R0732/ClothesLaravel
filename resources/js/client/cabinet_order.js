    // Додатковий JS: закриває інші collapse, коли відкривається новий
document.querySelectorAll('.list-group-item[data-bs-toggle="collapse"]').forEach(item => {
    item.addEventListener('click', () => {
        const targetId = item.getAttribute('data-bs-target');
        document.querySelectorAll('.order-details.collapse').forEach(el => {
            if ('#' + el.id !== targetId) {
                const bsCollapse = bootstrap.Collapse.getInstance(el);
                if (bsCollapse) bsCollapse.hide();
            }
        });
    });
});
