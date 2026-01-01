<form action="{{ route('admin.pages.blocks.update', [$page, $block]) }}" method="POST" class="space-y-4"
      onsubmit="syncEidRows{{ $block->id }}()">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input name="title" value="{{ $block->data['title'] ?? 'EID JAMAT' }}"
               class="mt-1 w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Rows</label>
        <div id="eidWrap{{ $block->id }}" class="space-y-2"></div>

        <button type="button"
                class="mt-2 inline-flex px-3 py-2 rounded-lg border text-sm hover:bg-gray-50"
                onclick="addEidRow{{ $block->id }}('', '')">
            + Add Jamaat Time
        </button>
    </div>

    <div id="hiddenEidInputs{{ $block->id }}"></div>

    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        Save Eid Times Block
    </button>
</form>

<script>
(function () {
    const rows = @json($block->data['rows'] ?? []);
    rows.forEach(r => addEidRow{{ $block->id }}(r.label || '', r.time || ''));
    if (!rows.length) addEidRow{{ $block->id }}('1st Jamat', '08:00');

    window.addEidRow{{ $block->id }} = function (label, time) {
        const wrap = document.getElementById('eidWrap{{ $block->id }}');
        const row = document.createElement('div');
        row.className = "grid grid-cols-1 md:grid-cols-3 gap-2 items-center";
        row.innerHTML = `
            <input type="text" class="rounded-lg border-gray-300" value="${escapeHtml(label)}" placeholder="1st Jamat">
            <input type="time" class="rounded-lg border-gray-300" value="${escapeHtml(time)}">
            <button type="button" class="px-3 py-2 rounded-lg border text-sm hover:bg-gray-50">Delete</button>
        `;
        row.querySelector('button').addEventListener('click', () => row.remove());
        wrap.appendChild(row);
    }

    window.syncEidRows{{ $block->id }} = function () {
        const wrap = document.getElementById('eidWrap{{ $block->id }}');
        const hidden = document.getElementById('hiddenEidInputs{{ $block->id }}');
        hidden.innerHTML = '';

        const rows = [...wrap.children].map(row => {
            const inputs = row.querySelectorAll('input');
            return {
                label: inputs[0].value.trim(),
                time: inputs[1].value.trim()
            };
        }).filter(r => r.label && r.time);

        rows.forEach((r, idx) => {
            const i1 = document.createElement('input');
            i1.type = 'hidden';
            i1.name = `rows[${idx}][label]`;
            i1.value = r.label;
            hidden.appendChild(i1);

            const i2 = document.createElement('input');
            i2.type = 'hidden';
            i2.name = `rows[${idx}][time]`;
            i2.value = r.time;
            hidden.appendChild(i2);
        });
    }

    function escapeHtml(str) {
        return (str || '').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'","&#039;");
    }
})();
</script>
