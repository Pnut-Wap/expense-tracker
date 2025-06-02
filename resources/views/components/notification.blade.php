<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if (session('success'))
            new Noty({
                type: 'success',
                layout: 'topRight',
                theme: 'metroui',
                text: '{{ session('success') }}',
                timeout: 2000
            }).show();
        @endif

        @if (session('error'))
            new Noty({
                type: 'error',
                layout: 'topRight',
                theme: 'metroui',
                text: '{{ session('error') }}',
                timeout: 2000
            }).show();
        @endif

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
                theme: 'metroui',
                text: errorText,
                timeout: 5000
            }).show();
        @endif
    });
</script>
