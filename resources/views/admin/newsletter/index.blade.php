@extends('layouts.dashboard')

@section('title','Newsletter Management')
@section('header','Newsletter Management')

@section('content')
<div class="space-y-6">
    
    {{-- Welcome Section --}}
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-8 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Newsletter Management</h1>
                <p class="text-blue-100 text-lg">Manage subscribers and send email campaigns</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Newsletter Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Send Newsletter --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Send Newsletter</h3>
                <span class="text-sm text-gray-500">{{ $subscribersCount ?? 0 }} subscribers</span>
            </div>
            
            <form action="{{ route('admin.newsletter.send') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <input type="text" name="subject" id="subject" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="content" id="content" rows="6" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div class="flex items-center gap-4">
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Send Newsletter
                    </button>
                    <span class="text-sm text-gray-500">to all {{ $subscribersCount ?? 0 }} subscribers</span>
                </div>
            </form>
        </div>

        {{-- Export Subscribers --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Export Subscribers</h3>
                <span class="text-sm text-gray-500">{{ $subscribersCount ?? 0 }} total</span>
            </div>
            
            <div class="space-y-4">
                <p class="text-gray-600">Download your subscriber list for external use or analysis.</p>
                
                <div class="flex gap-3">
                    <a href="{{ route('admin.newsletter.export', ['format' => 'csv']) }}" 
                       class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                        Export as CSV
                    </a>
                    <a href="{{ route('admin.newsletter.export', ['format' => 'json']) }}" 
                       class="px-6 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition">
                        Export as JSON
                    </a>
                </div>
                
                <div class="text-sm text-gray-500">
                    <p>Includes: Email, Name, Subscription Date, Status</p>
                    <p class="mt-1">Last updated: {{ $lastExport ?? 'Never' }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Sent Newsletters --}}
    @if(!empty($newsletters) && $newsletters->isNotEmpty())
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Recent Newsletters</h3>
                <a href="{{ route('newsletters.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All Newsletters</a>
            </div>
            
            <div class="space-y-4">
                @foreach($newsletters as $newsletter)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $newsletter->title }}</h4>
                                <p class="text-sm text-gray-500">{{ $newsletter->sent_at->format('M d, Y') }} • {{ $newsletter->sent_count }} subscribers</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Sent
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">{{ Str::limit(strip_tags($newsletter->content), 100) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Subscribers List --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Subscribers List</h3>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500">Total: {{ $subscribersCount ?? 0 }}</span>
                <form action="{{ route('admin.newsletter.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" placeholder="Search subscribers..."
                           value="{{ request('search') }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Search
                    </button>
                </form>
            </div>
        </div>
        
        @if($subscribers->isEmpty())
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No subscribers yet</h3>
                <p class="mt-1 text-sm text-gray-500">Start building your email list by promoting the newsletter subscription.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($subscribers as $subscriber)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subscriber->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subscriber->name ?? 'Not provided' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subscriber->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('admin.newsletter.destroy', $subscriber) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Remove this subscriber?')">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($subscribers->hasPages())
                <div class="mt-4">
                    {{ $subscribers->links() }}
                </div>
            @endif
        @endif
    </div>

</div>

@endsection

@section('scripts')
<!-- Simple Rich Text Editor -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTextarea = document.getElementById('content');
    
    if (contentTextarea) {
        // Create toolbar
        const toolbar = document.createElement('div');
        toolbar.className = 'flex flex-wrap gap-2 mb-3 border-b pb-3';
        toolbar.innerHTML = `
            <button type="button" onclick="formatText('bold')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Bold</button>
            <button type="button" onclick="formatText('italic')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Italic</button>
            <button type="button" onclick="formatText('underline')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Underline</button>
            <button type="button" onclick="formatText('insertUnorderedList')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">List</button>
            <button type="button" onclick="formatText('insertOrderedList')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Numbered List</button>
            <button type="button" onclick="insertLink()" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Link</button>
            <button type="button" onclick="formatText('formatBlock', 'h2')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">H2</button>
            <button type="button" onclick="formatText('formatBlock', 'h3')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">H3</button>
            <button type="button" onclick="formatText('justifyLeft')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Left</button>
            <button type="button" onclick="formatText('justifyCenter')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Center</button>
            <button type="button" onclick="formatText('justifyRight')" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded">Right</button>
            <button type="button" onclick="formatText('removeFormat')" class="px-3 py-1 text-sm bg-red-100 hover:bg-red-200 rounded">Remove Format</button>
        `;
        
        // Make textarea contenteditable
        contentTextarea.style.minHeight = '300px';
        contentTextarea.style.resize = 'vertical';
        
        // Insert toolbar before textarea
        contentTextarea.parentNode.insertBefore(toolbar, contentTextarea);
        
        // Convert textarea to contenteditable div
        const editor = document.createElement('div');
        editor.id = 'content-editor';
        editor.contentEditable = 'true';
        editor.className = 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-h-[300px]';
        editor.innerHTML = contentTextarea.value || '';
        
        // Create hidden input to store content
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'content';
        hiddenInput.value = contentTextarea.value || '';
        
        // Replace textarea with editor
        contentTextarea.parentNode.replaceChild(editor, contentTextarea);
        editor.parentNode.appendChild(hiddenInput);
        
        // Sync content between editor and hidden input
        editor.addEventListener('input', function() {
            hiddenInput.value = editor.innerHTML;
        });
        
        // Form submission sync
        const form = editor.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                hiddenInput.value = editor.innerHTML;
            });
        }
    }
});

function formatText(command, value = null) {
    document.execCommand(command, false, value);
}

function insertLink() {
    const url = prompt('Enter the URL:');
    if (url) {
        document.execCommand('createLink', false, url);
    }
}
</script>
@endsection
