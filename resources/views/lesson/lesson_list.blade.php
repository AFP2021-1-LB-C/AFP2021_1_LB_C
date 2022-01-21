@include('layout.header')

<table class="table">
  <thead class="table-secondary">
  <tr>
    <th>Tananyag azonosítója</th>
    <th>Tananyag megnevezése</th>
    <th>Tananyag</th>
    <th>Kurzus neve</th>
    <th>Műveletek</th>
    <th>Tananyag</th>

  </tr>
</thead>
<tbody>
  @foreach ($items as $item)
  <tr>
    <td>{{$item -> id}}</td>
    <td>{{$item -> topic}}</td>
    <td>{{substr($item -> content, 0, 50)."..."}}</td>
    <td>{{$item -> course -> name}}</td>
    <td><a href="/admin/lesson/edit/{{$item -> id}}">Szerkesztés</a></td>
    <td><a href="/admin/lesson/content/{{$item -> id}}">Teljes tananyag</a></td>
  </tr>  
  @endforeach

</tbody>
</table>

@include('layout.footer')
