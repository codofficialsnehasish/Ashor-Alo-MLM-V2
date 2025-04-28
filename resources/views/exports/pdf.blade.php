<!DOCTYPE html>
<html>
<head>
    <title>PDF Export</title>
    <style>table { width: 100%; border-collapse: collapse; } td, th { border: 1px solid #000; padding: 4px; }</style>
</head>
<body>
    <h2>Exported Data</h2>
    <table>
        <thead>
            <tr>
                @foreach ($data->first()->getAttributes() ?? [] as $key => $val)
                    <th>{{ $key }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $record)
                <tr>
                    @foreach ($record->getAttributes() as $val)
                        <td>{{ $val }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
