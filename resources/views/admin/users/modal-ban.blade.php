<div id="modal-ban" class="d-none">
    <div class="row"> 
        <div class="col-md-12">
            <form id="modal-ban-form" action="admin/users/${id}/ban" method="post">
                @method('PUT')
                @csrf
                
                <div class="form-group">
                    <p class="fw-500">¿Desea enviar un mensaje al usuario para informar de la causa del bloqueo?</p>
                    <div class="form-check radio">
                        <label class="form-check-label" for="send-message-1">
                        <input class="form-check-input bootbox-input bootbox-input-radio" type="radio" name="send-message" id="send-message-1" value="1" checked>Si</label>
                    </div>
                    <div class="form-check radio">
                        <label class="form-check-label" for="send-message-0">
                        <input class="form-check-input bootbox-input bootbox-input-radio" type="radio" name="send-message" id="send-message-0" value="0">No</label>
                    </div>
                </div>
                <div class="form-group" id="message-section">
                    <label class="form-label" for="message">Mensaje para el usuario</label>
                    <textarea id="message" name="message" class="form-control input-md">Su usuario fue bloqueado por incumplimiento de...</textarea>
                </div>
            </form>
        </div>
    </div>
</div>
    