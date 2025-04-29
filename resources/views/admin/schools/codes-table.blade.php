@foreach ($codes as $code)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $code['standard'] }}</td>
        <td>{{ $code['code'] }}</td>
    </tr>
@endforeach
