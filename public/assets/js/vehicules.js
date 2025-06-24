document.addEventListener('DOMContentLoaded', () => {
    let assignmentModal = document.getElementById('assignmentModal');

    assignmentModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let vehiculeId = button.getAttribute('data-vehicule-id');
        console.log(" Vehicule ID attr trouvé:", vehiculeId);

        document.getElementById('modal_vehicule_id').value = vehiculeId;
    });

    document.getElementById('assignmentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let form = this;
        let formData = new FormData(form);

        fetch(assignmentStoreRoute, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(" Réponse:", data);

            if(data.success) {
                alert(data.message);
                form.reset();
                bootstrap.Modal.getInstance(assignmentModal).hide();
                location.reload();
            } else {
                alert("Erreur: " + (data.message || 'Une erreur est survenue.'));
            }
        })
        .catch(error => {
            console.error(" Erreur:", error);
            alert("Erreur serveur.");
        });
    });

    // Activate tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
