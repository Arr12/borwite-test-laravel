<div class="sidebar d-flex flex-column" style="height: 100vh; ">
    <a href='{{ route('travel')}}' class="px-5 py-3 d-flex flex-row {{ Route::currentRouteName() == 'travel' ? 'bg-secondary text-white' : 'text-dark' }}" style="text-decoration: none;">
        <i class="bi bi-suitcase-lg-fill mr-3"></i>
        Official Travel
    </a>
</div>
