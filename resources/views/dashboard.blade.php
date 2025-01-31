<h3>Welcome, {{ Auth::user()->name }}</h3>
<h4>Data:</h4>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->age }}</td>
                <td>{{ $item->address }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
