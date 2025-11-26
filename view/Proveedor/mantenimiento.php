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
                    <input type="hidden" name="prov_id" id="prov_id" />

                    <div class="mb-3">
                        <label class="form-label">Tipo de Persona</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_persona" id="radioNatural" value="1" checked>
                                <label class="form-check-label" for="radioNatural">Natural</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_persona" id="radioJuridica" value="2">
                                <label class="form-check-label" for="radioJuridica">Jurídica</label>
                            </div>
                        </div>
                    </div>

                    <div id="natural_fields">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="primer_nombre" class="form-label">Primer Nombre (*)</label>
                                <input type="text" class="form-control" id="primer_nombre" name="primer_nombre">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                                <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="primer_apellido" class="form-label">Primer Apellido (*)</label>
                                <input type="text" class="form-control" id="primer_apellido" name="primer_apellido">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cedula" class="form-label">Cédula (*)</label>
                            <input type="text" class="form-control" id="cedula" name="cedula">
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                        </div>
                    </div>

                    <div id="juridica_fields" style="display: none;">
                        <div class="mb-3">
                            <label for="razon_social" class="form-label">Razón Social (*)</label>
                            <input type="text" class="form-control" id="razon_social" name="primer_nombre">
                        </div>
                        <div class="mb-3">
                            <label for="ruc_juridico" class="form-label">RUC (*)</label>
                            <input type="text" class="form-control" id="ruc_juridico" name="ruc">
                        </div>
                    </div>

                    <div id="common_fields">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>

                            <textarea class="form-control" id="direccion" name="direccion" rows="4" style="resize: none;"></textarea>
                        </div>
                        <input type="hidden" id="suc_id" name="sucursal_id" value="1">

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