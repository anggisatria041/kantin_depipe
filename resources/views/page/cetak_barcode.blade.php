<html>

<head>
    <title>GENERATE BARCODE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <center class="line">
            <h2>BARCODE</h2>
        </center>
    </div>

    <table class="table responsive-sm">
        <tr>
            <td colspan="8" align="center">
                <h6>BARCODE</h6>
            </td>
        </tr>
        <thead>
            <tr>
                <th>No</th>
                <th>No Meja</th>
                <th>Barcode</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($data as $row)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{$row->no_meja}}</td>
                <td>{{$row->barcode}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
