<div class="events-section">
    <h2 class="section-title">🕌 Upcoming Events at Ipswich Mosque</h2>
    <p class="section-subtitle">Stay connected with our community and activities</p>

    <div class="events-grid">
        @forelse($events as $event)
            <div class="event-card">
                <div class="event-date">
                    <span class="day">{{ $event->starts_at->format('d') }}</span>
                    <span class="month">{{ $event->starts_at->format('M') }}</span>
                </div>
                <div class="event-details">
                    <h3>{{ $event->title }}</h3>
                    <p class="event-time">
                        {{ $event->starts_at->format('g:i A') }}
                        @if($event->location) – {{ $event->location }} @endif
                    </p>
                    <p class="event-desc">{{ $event->description }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No upcoming events right now.</p>
        @endforelse
    </div>
</div>
