{{-- Modal d'assignation--}}
<div class="modal fade" id="assignmentModal" tabindex="-1" aria-labelledby="assignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="assignmentModalLabel" style="color: #0070BB">{{ __('vehicule.assign_vehicle') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="assignmentForm">
            @csrf
            <input type="hidden" name="vehicule_id" id="modal_vehicule_id">

            <div class="mb-3">
              <label for="driver_id">{{ __('vehicule.driver') }}</label>
              <select name="driver_id" class="form-select"  id="driver_id">
                @foreach($drivers as $driver)
                  <option value="{{ $driver->id }}">{{ $driver->nom }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="date_debut">{{ __('vehicule.start_date') }}</label>
              <input type="date" name="date_debut" id="date_debut" class="form-control">
            </div>

            <div class="mb-3">
              <label for="type_affectation">{{ __('vehicule.assignment_type') }}</label>
              <select name="type_affectation" id="type_affectation" class="form-select">
                <option value="">{{ __('vehicule.select_type') }}</option>
                <option value="permanente">{{ __('vehicule.permanent') }}</option>
                <option value="temporaire">{{ __('vehicule.temporary') }}</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="remarques">{{ __('vehicule.remarks') }}</label>
              <textarea name="remarques" id="remarques" class="form-control"></textarea>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">{{ __('vehicule.assign') }}</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('vehicule.cancel') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>