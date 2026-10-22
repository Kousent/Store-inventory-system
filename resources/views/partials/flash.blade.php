@if (session('success'))
    <div role="status" class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div role="alert" class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
        <ul class="list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
