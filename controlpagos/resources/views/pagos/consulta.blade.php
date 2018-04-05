
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="{{ URL::asset('js/datapicker/daterangepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/daterangepicker.css') }}" />

    <!-- page content -->

    <h2>Consulta de Pagos </h2><hr />

    <div class="item form-group">
        <!--label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;</label-->
        <div class="col-md-3">
            <input class="flat" type="radio" name="consulta" id="Pendientes" value="1" <?php if ($consulta==1) echo "checked"; ?> /> Pendientes
            <input class="flat" type="radio" name="consulta" id="Pagos" value="2" <?php if ($consulta==2) echo "checked"; ?> /> Pagos
            <input class="flat" type="radio" name="consulta" id="Todos" value="3" <?php if ($consulta==3) echo "checked"; ?> /> Todos
        </div>
        <div class="col-md-3">
            <select name="id_clinica" class="select2_single form-control" tabindex="-1">
                <?php
                    $sql = "select * from clinica_medico where id_medico=".Session::get("id_medico")." order by 2";
                    $data=DB::select($sql);
                    foreach ($data as $data)
                        if ($id_clinica==$data->id_clinica)
                            echo "<option value=".$data->id_clinica." selected>".$data->nombre."</option>";
                        else
                            echo "<option value=".$data->id_clinica.">".$data->nombre."</option>";
                ?>
            </select>
        </div>          
        <div class="col-md-3">
            <input type="text" name="fecha" required="required" class="form-control" placeholder="Fecha de Cirugia" value="<?php echo $fecha1; ?> - <?php echo $fecha2; ?>" />
            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
        </div>    
    </div>

    <div align="center"><input type="submit" name="send" class="btn btn-success" value="Buscar Cirugias" /></div>
    <!-- /page content -->

    <script type="text/javascript">
        $(function() {
            $('input[name="fecha"]').daterangepicker();
        });
    </script>