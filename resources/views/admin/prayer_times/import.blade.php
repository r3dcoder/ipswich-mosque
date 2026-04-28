@extends('layouts.dashboard')

@section('title', 'Import Prayer Times')
@section('header', 'Import Prayer Times')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.prayer-times.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
            ← Back to Prayer Times
        </a>
    </div>

    <div class="bg-white border rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-2">Bulk Import Prayer Times</h2>
        <p class="text-sm text-gray-600 mb-6">
            Upload exactly 12 Excel files (one for each month) to import prayer times. 
            Files must be named using 3-letter month abbreviations: Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec.
        </p>

        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                <ul class="list-disc list-inside text-sm text-red-800">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.prayer-times.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Select 12 Files (One for each month)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                    <input type="file" name="files[]" id="files" multiple accept=".xlsx,.xls,.csv" 
                           class="hidden" required>
                    <label for="files" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-medium text-gray-900">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500">Excel files only (.xlsx, .xls, .csv)</p>
                    </label>
                </div>
                
                <div id="file-list" class="mt-4"></div>
                
                <p class="mt-2 text-xs text-gray-500">
                    Selected: <span id="file-count">0</span>/12 files
                </p>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.prayer-times.index') }}" class="px-4 py-2 text-sm text-gray-700 border rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800">
                    Import Prayer Times
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 bg-white border rounded-xl p-6">
        <h3 class="text-sm font-semibold mb-3">File Naming Guidelines:</h3>
        <ul class="text-sm text-gray-600 space-y-1">
            <li>• File names must contain 3-letter month abbreviations: Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec</li>
            <li>• Example filenames: Jan.xls, Feb.xlsx, Mar.csv, Apr.xls, etc.</li>
            <li>• Supported formats: .xlsx, .xls, .csv</li>
            <li>• You must upload exactly 12 files (one for each month)</li>
            <li>• Each file should contain prayer times for one month</li>
            <li>• Existing prayer times will be deleted before import</li>
        </ul>
    </div>
</div>

<script>
document.getElementById('files').addEventListener('change', function(e) {
    const files = e.target.files;
    const fileCount = files.length;
    const fileList = document.getElementById('file-list');
    const countSpan = document.getElementById('file-count');
    
    countSpan.textContent = fileCount;
    
    // Clear previous list
    fileList.innerHTML = '';
    
    if (fileCount > 0) {
        const ul = document.createElement('ul');
        ul.className = 'text-sm text-gray-700 space-y-1';
        
        for (let i = 0; i < fileCount; i++) {
            const li = document.createElement('li');
            li.className = 'flex items-center justify-between py-1 border-b border-gray-100';
            li.innerHTML = `
                <span class="truncate">${files[i].name}</span>
                <span class="text-xs text-gray-500 ml-2">${(files[i].size / 1024).toFixed(1)} KB</span>
            `;
            ul.appendChild(li);
        }
        
        fileList.appendChild(ul);
        
        // Show warning if not exactly 12 files
        if (fileCount !== 12) {
            const warning = document.createElement('p');
            warning.className = 'mt-2 text-sm text-red-600';
            warning.textContent = `⚠️ You have selected ${fileCount} files. Please select exactly 12 files.`;
            fileList.appendChild(warning);
        } else {
            const success = document.createElement('p');
            success.className = 'mt-2 text-sm text-green-600';
            success.textContent = '✓ You have selected exactly 12 files.';
            fileList.appendChild(success);
        }
    }
});
</script>
@endsection