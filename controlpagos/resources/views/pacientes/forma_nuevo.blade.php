    <h2>Nuevo Paciente</h2> <hr />
	
	<span class="msj">{{ Session::get("mensaje") }}</span>
	

<input type="hidden" name="id" value="<?=$id?>" />

<div class="item form-group">
    <label class="control-label col-md-6 col-sm-6 col-xs-12">Nombres <span class="msj">(*)</span>:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="nombres" name="nombres" type="text" data-validate-length-range="3" data-validate-words="1" required="required" class="form-control" placeholder="Nombres" value="<?=$nombres?>">
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="apellidos" name="apellidos" type="text" data-validate-length-range="3" data-validate-words="1" class="form-control" placeholder="Apellidos" value="<?=$apellidos?>">
    </div>
</div>
<div class="item form-group">
    <label class="control-label col-md-6 col-sm-6 col-xs-12">Cedula <span class="msj">(*)</span>:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="cedula" name="cedula" type="text" class="form-control" placeholder="Cedula" required="required" value="<?=$cedula?>">
    </div>
</div>

<div class="item form-group">
    <label class="control-label col-md-6 col-sm-6 col-xs-12">Edad <span class="msj">(*)</span>:</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="edad" name="edad" type="number" class="form-control" data-validate-minmax="0,110" required="required" placeholder="Edad" value="<?=$edad?>">
    </div>
</div>