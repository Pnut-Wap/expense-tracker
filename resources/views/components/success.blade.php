@if (session('success'))
    new Noty({
    type: 'success',
    layout: 'topRight',
    text: '{{ session('success') }}',
    timeout: 3000
    }).show();
@endif
