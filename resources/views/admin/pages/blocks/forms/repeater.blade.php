<form action="{{ route('admin.pages.blocks.update', [$page, $block]) }}" method="POST" class="space-y-4"
      onsubmit="syncRepeaterInputs{{ $block->id }}()">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700">Title (optional)</label>
        <input name="title" value="{{ $block->data['title'] ?? '' }}"
               class="mt-1 w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Items</label>
        <div id="repeaterWrap{{ $block->id }}" class="space-y-2"></div>

        <button type="button"
                class="mt-2 inline-flex px-3 py-2 rounded-lg border text-sm hover:bg-gray-50"
                onclick="addRepeaterRow{{ $block->id }}('')">
            + Add Item
        </button>
    </div>

    <div id="hiddenRepeaterInputs{{ $block->id }}"></div>

    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        Save List Block
    </button>
</form>

<script>
(function () {
    const items = @json($block->data['items'] ?? []);
    items.forEach(v => addRepeaterRow{{ $block->id }}(v));
    if (!items.length) addRepeaterRow{{ $block->id }}('');

    window.addRepeaterRow{{ $block->id }} = function (value) {
        const wrap = document.getElementById('repeaterWrap{{ $block->id }}');
        const row = document.createElement('div');
        row.className = "flex gap-2";
        row.innerHTML = `
            <input type="text" class="flex-1 rounded-lg border-gray-300" value="${escapeHtml(value)}" placeholder="List item...">
            <button type="button" class="px-3 py-2 rounded-lg border text-sm hover:bg-gray-50">Delete</button>
        `;
        row.querySelector('button').addEventListener('click', () => row.remove());
        wrap.appendChild(row);
    }

    window.syncRepeaterInputs{{ $block->id }} = function () {
        const wrap = document.getElementById('repeaterWrap{{ $block->id }}');
        const hidden = document.getElementById('hiddenRepeaterInputs{{ $block->id }}');
        hidden.innerHTML = '';

        const values = [...wrap.querySelectorAll('input')]
            .map(i => i.value.trim())
            .filter(v => v.length);

        values.forEach((v, idx) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `items[${idx}]`;
            input.value = v;
            hidden.appendChild(input);
        });
    }

    function escapeHtml(str) {
        return (str || '').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'","&#039;");
    }
})();
</script>
