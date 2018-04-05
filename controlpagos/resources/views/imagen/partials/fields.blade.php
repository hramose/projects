<div class="form-group">
    <div class="clearfix"></div>
    <div class="item form-group">
        <label for="proveedor_id" class="control-label col-md-3 col-sm-3 col-xs-12">Codigo de Proveedor<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="proveedor_id" name="proveedor_id" type="text" required="required" class="form-control" data-validate-length-range="1" value="<?php if (!empty($proveedor)) echo $proveedor->proveedor_id; ?>">
        </div>
    </div>
    <div class="item form-group">
        <label for="tipo_rif" class="control-label col-md-3 col-sm-3 col-xs-12">Tipo RIF<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="tipo_rif" name="tipo_rif" type="text" required="required" class="form-control col-md-3 col-xs-6" data-validate-length-range="1" value="<?php if (!empty($proveedor)) echo $proveedor->tipo_rif; ?>">
        </div>
    </div>
    <div class="item form-group">
        <label for="rif" class="control-label col-md-3 col-sm-3 col-xs-12">RIF<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="rif" name="rif" type="text" required="required" class="form-control col-md-7 col-xs-12" data-validate-length-range="5" data-validate-words="1" value="<?php if (!empty($proveedor)) echo $proveedor->rif; ?>">
        </div>
    </div>
    <div class="item form-group">
        <label for="razon_social" class="control-label col-md-3 col-sm-3 col-xs-12">Razón social<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="razon_social"  name="razon_social" type="text" required="required" class="form-control col-md-7 col-xs-12" data-validate-length-range="5" data-validate-words="1" value="<?php if (!empty($proveedor)) echo $proveedor->razon_social; ?>">
        </div>
    </div>
    <div class="item form-group">
        <label for="tipo" class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de Proveedor<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="tipo" name="tipo" class="form-control col-md-7 col-xs-12" type="text" data-validate-length-range="1" value="<?php if (!empty($proveedor)) echo $proveedor->tipo; ?>">
        </div>
    </div>
</div>
