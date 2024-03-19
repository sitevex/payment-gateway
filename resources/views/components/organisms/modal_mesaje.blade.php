<!-- Modal -->
<div class="modal fade" id="{{ $modalId }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $modalSize }} modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header {{ $modalHeaderJustify}} border-0">
                <h1 class="modal-title fs-5 fw-bold" id="{{ $modalId }}Label">{{ $modalTitle }}</h1>
                @if ($showCloseButton)
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @endif
            </div>
            <div class="modal-body py-0 {{ $textAlign }}">
                {{ $slot }}
            </div>
            <div class="modal-footer border-0">
                {!! $modalFooter !!}
            </div>
        </div>
    </div>
</div>