@php
  $title = $data['title'] ?? 'EID JAMAT';
  $rows = $data['rows'] ?? [];
@endphp

<section class="mt-6 bg-white border rounded-2xl p-6">
    <h2 class="text-xl font-semibold">{{ $title }}</h2>

    @if(count($rows))
        <div class="mt-4 space-y-2">
            @foreach($rows as $r)
                <div class="flex items-center justify-between border rounded-lg px-4 py-2">
                    <div class="font-medium">{{ $r['label'] ?? '' }}</div>
                    <div class="text-gray-800">
                        @php
                            $t = $r['time'] ?? '';
                        @endphp
                        {{ $t ? \Carbon\Carbon::parse($t)->format('g:i A') : '—' }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-600 mt-2">No Eid Jamaat times set yet.</p>
    @endif

    <p class="text-xs text-gray-500 mt-3">* All Islamic dates and festivals are subject to the sighting of the moon.</p>
</section>
