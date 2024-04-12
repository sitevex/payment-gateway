<!-- Modal -->
<div class="modal fade" id="{{ $modalId }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $modalDialogClass }}">
        <div class="modal-content">
            <div class="modal-header {{ $modalHeaderClass }}">
                <div class="d-flex align-items-center mb-2 px-3 text-start w-100">
                    <h1 class="modal-title fs-6 fw-medium" id="{{ $modalId }}Label">{{ $modalTitle }} <b id="numberOrden"></b></h1>
                    @if ($showCloseButton)
                    <button type="button" class="btn-close fs-xxs" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>
                <div class="text-start w-100">
                    <ul class="nav nav-pills nav-detalleOrden gap-3 px-3 bg-white" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-0 py-1 rounded-0 active" id="pills-resume-tab" data-bs-toggle="pill" data-bs-target="#pills-resume" type="button" role="tab" aria-controls="pills-resume" aria-selected="true">Resumen</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-body {{ $modalBodyClass }}">
                {{ $slot }}
            </div>
            <div class="modal-footer border-0">
                {!! $modalFooter !!}
            </div>
        </div>
    </div>
</div>