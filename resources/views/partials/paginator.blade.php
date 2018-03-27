<table>
    <tr>
        <td>
            @if($products->render() != '')
                {{ $products->appends(\Illuminate\Support\Facades\Input::except(array('page')))->render() }}
            @endif
        </td>
    </tr>
</table>

@yield('products_paginator')