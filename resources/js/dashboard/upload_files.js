export default function initBoardgameFileUploader({ uploadUrl, csrfToken }) {
    let fileIdToDelete = null;
    let fileElementToDelete = null;

    // UPLOAD
    $('#upload_pdf_btn').on('click', function () {
        const fileInput = document.getElementById('pdf_file_input');
        const displayName = $('#pdf_display_name').val();

        if (!fileInput.files.length) {
            alert('Veuillez sélectionner un fichier PDF.');
            return;
        }

        if (!displayName) {
            alert('Veuillez entrer un nom à afficher.');
            return;
        }

        const formData = new FormData();
        formData.append('pdf_file', fileInput.files[0]);
        formData.append('display_name', displayName);
        formData.append('_token', csrfToken);

        $.ajax({
            url: uploadUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    const li = `
                        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="${response.file.id}">
                            <div>
                                <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>
                                ${response.file.display_name}
                            </div>
                            <div class="btn-group">
                                <a href="${response.file.url}" target="_blank" class="btn btn-outline-secondary btn-sm" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button class="btn btn-outline-danger btn-sm delete-file-btn" title="Supprimer" data-id="${response.file.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </li>`;
                    $('#existing-files').append(li);
                    $('#pdf_file_input').val('');
                    $('#pdf_display_name').val('');
                }
            },
            error: function () {
                alert("Erreur lors de l'upload du fichier.");
            }
        });
    });

    // OUVERTURE DU MODAL
    $('#existing-files').on('click', '.delete-file-btn', function () {
        fileIdToDelete = $(this).data('id');
        fileElementToDelete = $(this).closest('li');
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    });

    // CONFIRMATION DE SUPPRESSION
    $('#confirmDeleteBtn').on('click', function () {
        if (!fileIdToDelete || !fileElementToDelete) return;

        $.ajax({
            url: `/dashboard/boardgames/files/${fileIdToDelete}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function () {
                fileElementToDelete.fadeOut(300, function () {
                    $(this).remove();
                });
                bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal')).hide();
            },
            error: function () {
                alert('Erreur lors de la suppression du fichier.');
            }
        });
    });
}
