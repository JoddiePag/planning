<h5>Historique des Ordonnances</h5>

@if($ordonnances->isEmpty())
    <p>Aucune ordonnance trouvée pour ce patient.</p>
@else
    <table>
        <thead>
            <tr>
                <th>ID </th>
                <th>Type Ordonnance</th>
                <th>Date </th>
                </tr>
        </thead>
       <tbody>
    @foreach($ordonnances as $ordonnance)
       
        <!-- <tr class="cursor-pointer hover:bg-gray-100 transition duration-150 ease-in-out"
                      >
            <td>{{ $ordonnance->id }}</td>
            <td>{{ $ordonnance->type_ordonnance }}</td>
            <td>{{ $ordonnance->created_at->format('d/m/Y') }}</td>
        </tr> -->
         <tr class="cursor-pointer hover:bg-gray-100 transition duration-150 ease-in-out"
            onclick="window.location='{{ route('ordonnance_detail', ['ordonnance_id' => $ordonnance->id]) }}';">
            <td>{{ $ordonnance->id }}</td>
            <td>{{ $ordonnance->type_ordonnance }}</td>
            <td>{{ $ordonnance->created_at->format('d/m/Y') }}</td>
        </tr>
    @endforeach
</tbody>
    </table>
@endif
<style>

    .cursor-pointer {
        cursor: pointer;
    }
</style>