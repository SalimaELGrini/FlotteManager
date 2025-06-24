@if(session('success') || session('error') || session('info') || session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let type = '';
        let title = '';
        let message = '';

        @if(session('success'))
            type = 'success';
            title = 'Succès';
            message = '{{ session("success") }}';
        @elseif(session('error'))
            type = 'Erreur';
            message = '{{ session("error") }}';
        @elseif(session('warning'))
            type = 'Attention';
            message = '{{ session("warning") }}';
        @elseif(session('info'))
            type = 'Info';
            message = '{{ session("info") }}';
        @endif

        const customIcon = `
            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none" stroke="#0070BB" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" stroke="#0070BB" stroke-width="2.5" fill="none"></circle>
                    <polyline points="9 12 12 15 16 10" stroke="#0070BB" stroke-width="2.5"></polyline>
                </svg>
            </div>
        `;

        const Toast = Swal.mixin({
            customClass: {
                popup: 'my-swal-popup',
                title: 'my-swal-title',
                confirmButton: 'my-swal-button'
            },
            confirmButtonColor: '#0070BB',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });

        Toast.fire({
            html: customIcon + `<h4 style="color:#0070BB; font-weight:bold; margin:0 0 5px 0;">${title}</h4><p>${message}</p>`
        });
    });
</script>

<style>
.my-swal-title {
    color: #0070BB !important;
    font-weight: bold;
}

.my-swal-popup .swal2-html-container,
.my-swal-popup .swal2-content {
    color: #0070BB !important;
    font-size: 15px;
}

.my-swal-button {
    background-color: #0070BB !important;
    color: #fff !important;
}
</style>
@endif


