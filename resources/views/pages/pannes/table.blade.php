@foreach ($pannes as $panne)
<tr>
    <td>{{ $panne->id }}</td>
    <td>{{ $panne->vehicule->numero ?? 'N/A' }}</td>
    <td>{{ $panne->date_panne }}</td>
    <td>{{ $panne->resolved ? 'Yes' : 'No' }}</td>
    <td>
        <a href="{{ route('pannes.show', $panne->id) }}" class="btn btn-info">View</a>
        <a href="{{ route('pannes.edit', $panne->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('pannes.destroy', $panne->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('interventions.create', ['panne_id' => $panne->id, 'vehicule_id' => $panne->vehicule->id]) }}" class="btn btn-success">Intervention</a>
    </td>
</tr>
@endforeach