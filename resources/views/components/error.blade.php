@if (session('error'))
    new Noty({
    type: 'error',
    layout: 'topRight',
    text: '{{ session('error') }}',
    timeout: 3000
    }).show();
@endif
