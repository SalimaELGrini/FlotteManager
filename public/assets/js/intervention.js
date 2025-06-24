
    $(document).ready(function () {
        // Injecter l'ID dans le champ caché quand on clique sur le bouton
        $('#neussiteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var interventionId = button.data('intervention-id');
            $('#intervention_id_neussite').val(interventionId);
        });

        $('#neussiteForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('neussite.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    alert(response.message);
                    $('#neussiteModal').modal('hide');
                    location.reload();
                },
                error: function(response) {
                    alert("Erreur lors de l'ajout de la pièce");
                }
            });
        });
    });
    
// tooltip initialization
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
