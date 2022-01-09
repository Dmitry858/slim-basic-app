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

    const excerpt = document.getElementById('excerpt'),
          content = document.getElementById('content');

    if (excerpt) CKEDITOR.replace('excerpt');
    if (content) CKEDITOR.replace('content');
});