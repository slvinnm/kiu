<div class="modal modal-borderless fade text-left" id="logout-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabel120">Keluar</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                Apa anda yakin ingin keluar ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn rounded-pill btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i> Batal
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn rounded-pill btn-danger ms-1">
                        <i class="bi bi-box-arrow-right me-1"></i> Lanjut
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
