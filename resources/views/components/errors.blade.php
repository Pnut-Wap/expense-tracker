@if ($errors->any())
    let errorText =
    `<ul style="padding-left: 20px;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>`;
    new Noty({
    type: 'error',
    layout: 'topRight',
    text: errorText,
    timeout: 5000
    }).show();
@endif
