<div class="col-md-3">
    <?php
        $sql = "select * from clinica_medico where id_medico=".Session::get("id_medico")." order by 2";
        $data=DB::select($sql);
    ?>
    <select name="id_clinica" class="select2_single form-control" tabindex="-1">
        <?php
            foreach ($data as $data)
                if ($id_clinica==$data->id_clinica)
                    echo "<option value=".$data->id_clinica." selected>".$data->nombre."</option>";
                else
                    echo "<option value=".$data->id_clinica.">".$data->nombre."</option>";
        ?>
    </select>
</div>          
