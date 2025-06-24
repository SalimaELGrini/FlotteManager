document.addEventListener('DOMContentLoaded', function () {
    const driverSelect = document.getElementById('driver_id');
    const statusDiv = document.getElementById('status_div');
    const statusSelect = document.getElementById('status');
    const form = document.querySelector('form');

    driverSelect.addEventListener('change', function () {
        if (this.value) {
            statusDiv.style.display = 'block';
        } else {
            statusDiv.style.display = 'none';
            statusSelect.value = '';
        }
    });

    form.addEventListener('submit', function (event) {
        const driverId = driverSelect.value;
        const status = statusSelect.value;
        if (driverId && !status) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Attention',
                text: 'Veuillez sélectionner une situation.'
            });
        }
    });
});
