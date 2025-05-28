<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


<style>
/*-------admin order susmita 20-05-25-----*/
    .addon-order-item {
    margin-right: 10px;
    border: 1px solid #99999961;
    padding: 5px;
}
.table>:not(:last-child)>:last-child>* {
    border-bottom-color: currentColor;
    font-size: 12px;
}
.table .badge {
    text-transform: uppercase;
    font-size: 12px;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
 {
    line-height: 24px;
    vertical-align: top;
    font-size: 12px;
}
</style>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
