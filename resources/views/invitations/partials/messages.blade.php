
<div class="message-list">
    @forelse ($messages as $message)
        <article class="message-card">
            <div class="message-header">
                <strong>{{ $message->guest_name }}</strong>

                <span class="message-time">
                    {{ $message->created_at
                        ->locale('id')
                        ->translatedFormat('d M Y, H:i') }}
                    WITA
                </span>
            </div>

            @if ($message->message)
                <p class="message-content">
                    {{ $message->message }}
                </p>
            @endif
        </article>
    @empty
        <p style="text-align:center;color:var(--muted)">
            Jadilah yang pertama memberikan ucapan dan doa.
        </p>
    @endforelse
</div>

@if ($messages->hasPages())
    <div class="message-pagination">
        {{ $messages->onEachSide(1)->links('vendor.pagination.baliutsava') }}
    </div>
@endif
