@props([
    'id',
    'title' => 'Modal',
])

<div id="{{ $id }}" class="ui-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title">
    <div class="ui-modal-backdrop" data-modal-close></div>
    <div class="ui-modal-panel" role="document">
        <div class="ui-modal-header">
            <h3 id="{{ $id }}-title">{{ $title }}</h3>
            <button type="button" class="ui-modal-close" data-modal-close aria-label="Tutup">&times;</button>
        </div>
        <div class="ui-modal-body">
            {{ $slot }}
        </div>
    </div>
</div>
