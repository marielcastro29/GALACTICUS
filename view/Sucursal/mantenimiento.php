<div id="modalmantenimiento" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <!-- TODO: Formulario de Mantenimiento -->
            <form method="post" id="mantenimiento_form">
                <div class="modal-body">
                    <input type="hidden" name="suc_id" id="suc_id" />

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="suc_nom" name="suc_nom" required />

                                <label for="valueInput" class="form-label">Correo</label>
                                <input type="text" class="form-control" id="suc_cor" name="suc_cor" required />

                                <label for="valueInput" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="suc_tel" name="suc_tel" required />

                                <label for="exampleFormControlTextarea5" class="form-label">Dirección</label>
                                <textarea class="form-control" id="suc_dir" name="suc_dir" rows="3"></textarea>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" value="add" class="btn btn-primary ">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>