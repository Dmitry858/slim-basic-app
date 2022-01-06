window.addEventListener('load', function() {
    const deleteIcons = document.querySelectorAll('.delete-icon');

    if (deleteIcons.length > 0) {
        for (let icon of deleteIcons) {
            icon.addEventListener('click', function(event) {
                const result = confirm('Удалить?');
                if (!result) event.preventDefault();
            });
        }
    };
});