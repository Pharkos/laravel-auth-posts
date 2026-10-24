@if(session('success'))
    <p class="alert-message alert-success">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p class="alert-message alert-error">{{ session('error') }}</p>
@endif

@if(session('warning'))
    <p class="alert-message alert-warning">{{ session('warning') }}</p>
@endif

@if(session('info'))
    <p class="alert-message alert-info">{{ session('info') }}</p>
@endif