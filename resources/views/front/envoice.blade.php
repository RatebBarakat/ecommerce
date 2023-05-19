<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        body { font-family: DejaVu Sans; }
        tr,td,th{
            border: 1px solid black;
            text-align: center;
            text-align: center;
        }
    </style>
</head>
<body>
<div style="margin-top: 60px" class="container">
    <header>
        <div style="display: flex;justify-content: space-between;">
        </div>
        <table style="border-collapse: collapse;min-width: 100%;border-color: transparent">
            <th style="border-color: transparent">
                <td style="text-align: start;width: 50%;border-color: transparent">Shop</td>
                <td style="text-align: end;border-color: transparent">published at : 2022</td>
            </th>
        </table>
        <hr>
        <div class="text-center">rateb envoice</div>
    </header>

    <table style="border-collapse: collapse;border: 1px solid black;min-width: 90%"
           class="my-4 text-center table-bordered bg-white table table-responsive">
        @php($i=0)
        @php($total = 0)
        <tr style="background: lightgrey">
            <th class="">#</th>
            <th class="">{{__('name')}}</th>
            <th class="">{{__('price')}}</th>
            <th class="">{{__('quantity')}}</th>
            <th class="">{{__('Total')}}</th>
        </tr>
        @foreach($cards as $card)
            <tr class="text-center">
                <td>{{$i}}</td>
                <td>{{$card->name}}</td>
                <td>{{$card->price}}</td>
                <td>{{$card->quantity}}</td>
                <td>{{$card->quantity * $card->price}}</td>
            </tr>
            @php($i++)
            @php($total+=($card->price * $card->quantity))
        @endforeach
            <td colspan="4">{{__('final price')}}</td>
            <td>{{$total}}</td>
    </table>
</div>
<p style="text-align: center">tank for pay from out website the payment will when you reciece your order
    <span>Contact Us at
        <a class="btn btn-info" href="https://wa.me/70121430" target="_blank">Whatsapp</a>
    </span>
</p>
</body>
</html>

