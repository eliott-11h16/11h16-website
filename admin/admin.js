// ─── Drag & Drop Reorder ────────────────────

const projectList = document.getElementById('projectList');
if (projectList) {
    let dragRow = null;

    projectList.querySelectorAll('tr').forEach(row => {
        const handle = row.querySelector('.drag-handle');
        if (!handle) return;

        handle.addEventListener('mousedown', () => {
            dragRow = row;
            row.style.opacity = '0.5';
        });
    });

    document.addEventListener('mouseup', () => {
        if (dragRow) {
            dragRow.style.opacity = '1';
            dragRow = null;
            saveOrder();
        }
    });

    projectList.addEventListener('dragover', e => e.preventDefault());

    // Simple click-to-move-up for now (more reliable than drag)
    projectList.querySelectorAll('.drag-handle').forEach(handle => {
        handle.title = 'Drag to reorder';
    });
}

function saveOrder() {
    const form = document.getElementById('reorderForm');
    if (!form) return;

    const rows = document.querySelectorAll('#projectList tr[data-id]');
    // Remove old hidden inputs
    form.querySelectorAll('input[name="ids[]"]').forEach(i => i.remove());

    rows.forEach(row => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = row.dataset.id;
        form.appendChild(input);
    });

    form.submit();
}

// ─── Media Upload ───────────────────────────

function uploadMedia(files, projectId) {
    const formData = new FormData();
    formData.append('project_id', projectId);

    for (let i = 0; i < files.length; i++) {
        formData.append('files[]', files[i]);
    }

    fetch('media-upload.php', {
        method: 'POST',
        body: formData,
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Upload error: ' + (data.error || 'Unknown'));
        }
    })
    .catch(err => alert('Upload failed: ' + err.message));
}

// ─── Media Delete ───────────────────────────

function deleteMediaItem(id) {
    if (!confirm('Delete this media?')) return;

    fetch('media-delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id,
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const el = document.querySelector(`.media-item[data-id="${id}"]`);
            if (el) el.remove();
        }
    });
}

// ─── Media Layout Update ────────────────────

function updateMediaLayout(id, layout) {
    fetch('media-update.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&layout=${layout}&grid_group=0&alt_text=`,
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) alert('Update failed');
    });
}
