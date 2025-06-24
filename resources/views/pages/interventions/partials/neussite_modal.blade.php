<!-- Modal -->
<div class="modal fade" id="neussiteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #0070BB">
                    {{ __('intervention.add_neussite') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('intervention.close_btn') }}"></button>
            </div>
            <div class="modal-body">
                <form id="neussiteForm">
                    @csrf
                    <input type="hidden" name="intervention_id" id="intervention_id_neussite">

                    <div class="mb-3">
                        <label for="piece_id" class="form-label">{{ __('intervention.piece_label') }}</label>
                        <select class="form-control" name="piece_id" required>
                            <option value="">{{ __('intervention.select_piece') }}</option>
                            @foreach($pieces as $piece)
                                <option value="{{ $piece->id }}">{{ $piece->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_change" class="form-label">{{ __('intervention.date_change_label') }}</label>
                        <input type="date" class="form-control" name="date_change" required>
                    </div>
                    <div class="mb-3">
                        <label for="prix_piece" class="form-label">{{ __('intervention.price_label') }}</label>
                        <input type="number" step="0.01" class="form-control" name="prix_piece" required>
                    </div>
                    <div class="mb-3">
                        <label for="nom_technicien" class="form-label">{{ __('intervention.technician_label') }}</label>
                        <input type="text" class="form-control" name="nom_technicien" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">{{ __('intervention.status_label') }}</label>
                        <select class="form-control" name="status" required>
                            <option value="">{{ __('intervention.select_status') }}</option>
                            <option value="en_attente">{{ __('intervention.status_pending') }}</option>
                            <option value="terminée">{{ __('intervention.status_completed') }}</option>
                            <option value="en_cours">{{ __('intervention.status_in_progress') }}</option>
                        </select>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">{{ __('intervention.btn_add') }}</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('intervention.btn_cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>