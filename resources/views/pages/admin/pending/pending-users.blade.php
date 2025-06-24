@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('messages.pending_users') }}</h3>
                </div>

                <div id="approve-alert" class="d-none p-3 rounded text-center mb-3" style="color:#0093AF;" role="alert"
                     style="background: transparent; border: 1px solid white;">
                </div>

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">{{ __('messages.name') }}</th>
                                <th class="text-center">{{ __('messages.email') }}</th>
                                <th class="text-center">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr id="user-row-{{ $user->id }}">
                                    <td class="text-center">{{ $user->username }}</td>
                                    <td class="text-center">{{ $user->email }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-link btn-sm btn-approve me-2" style="color:#0093AF;" data-id="{{ $user->id }}">
                                            <i class="fas fa-check-circle"></i> {{ __('messages.approve') }}
                                        </button>
                                        <button  class="btn btn-link btn-sm btn-refuse" style="color:#DC3545;" data-id="{{ $user->id }}">
                                            <i class="fas fa-times-circle"></i> {{ __('messages.refuse') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center"></div>
            </div>
        </div>
    </div>
</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(function () {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('.btn-approve').click(function () {
      if (!confirm("Êtes-vous sûr de vouloir approuver cet utilisateur ?")) return;

      let userId = $(this).data('id');
      let row = $('#user-row-' + userId);

      $.ajax({
        url: '/admin/utilisateurs/' + userId + '/approuver',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        success: function (response) {
          $('#approve-alert')
            .text(response.message)
            .removeClass('d-none')
            .css({
              'color': '#0093AF',
              'background': 'transparent',
              'border': '1px solid white'
            });

          row.remove();
          setTimeout(() => {
            $('#approve-alert').addClass('d-none');
          }, 3000);
        },
        error: function () {
          $('#approve-alert')
            .text("Une erreur est survenue lors de l'approbation de l'utilisateur.")
            .removeClass('d-none')
            .css({
              'color': '#0093AF',
              'background': 'transparent',
              'border': '1px solid white'
            });
        }
      });
    });

    $('.btn-refuse').click(function () {
      if (!confirm("Êtes-vous sûr de vouloir refuser cet utilisateur ?")) return;

      let userId = $(this).data('id');
      let row = $('#user-row-' + userId);

      $.ajax({
        url: '/admin/utilisateurs/' + userId + '/refuser',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        success: function (response) {
          $('#approve-alert')
            .text(response.message)
            .removeClass('d-none')
            .css({
              'color': 'white',
              'background': 'transparent',
              'border': '1px solid white'
            });

          row.remove();
          setTimeout(() => {
            $('#approve-alert').addClass('d-none');
          }, 3000);
        },
        error: function () {
          $('#approve-alert')
            .text("Une erreur est survenue lors du refus de l'utilisateur.")
            .removeClass('d-none')
            .css({
              'color': 'white',
              'background': 'transparent',
              'border': '1px solid white'
            });
        }
      });
    });
  });
</script>
@endsection

