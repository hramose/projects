        <div class="col-md-3">
            <input class="flat" type="radio" name="consulta" id="Pendientes" value="1" @if (isset($consulta) && ($consulta==1)) echo "checked"; @endif /> Pendientes
            <input class="flat" type="radio" name="consulta" id="Pagos" value="2" @if (isset($consulta) && ($consulta==2)) echo "checked"; @endif/> Pagos
            <input class="flat" type="radio" name="consulta" id="Todos" value="3" @if (isset($consulta) && ($consulta==3)) echo "checked"; @endif/> Todos
        </div>
