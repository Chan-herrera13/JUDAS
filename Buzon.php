<!DOCTYPE html>
<html lang="es">
    <head>
<!--Aqui se toma en consideracion el estilo antes creado el otro documento. -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style/EstiloBuzon.css">     
        <title>Buzón de Sugerencias y Quejas</title>
    </head>
<body>
    <h1>Buzón de Sugerencias y Quejas</h1>
<!--Aqui es donde empiza todo el formulario, con cada estilo de entrada de texto o seleccion -->
    <form action="Scripts/procesar.php" method="POST">
        <fieldset>

            <label for="departamento">Departamento:</label>
            <select id="departamento" name="departamento" required>
                <option value="">Selecciona una opción</option>
                <option value="SISTEMAS">SISTEMAS</option>
                <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
                <option value="SEGURIDAD Y SALUD EN EL SALUD">SEGURIDAD Y SALUD EN EL SALUD</option>
                <option value="DISEÑO">DISEÑO Y MARKETING</option>
                <option value="CONTABILIDAD">CONTABILIDAD</option>
                <option value="NIÑOS">NIÑOS</option>
                <option value="CAPACITACION">CAPACITACION</option>
                <option value="ADMINISTRACION">ADMINISTRACION</option>
                <option value="ENERGIA">ENERGIA</option>
                <option value="DERECHO">DERECHO</option>
                <option value="LICITACIONES">LICITACIONES</option>
            </select>


            <label for="Actividad">Actividad:</label>
            <select id="Actividad" name="Actividad" required>
                <option value="">Selecciona una opción</option>
                <option value="servicio">Servicio Social</option>
                <option value="practicas">Prácticas Profesionales</option>
                <option value="jovenes">Jovenes Construyendo el Futuro</option>
            </select>
            <label>¿Qué es lo que quieres escribir?</label>
            <input type="radio" id="sugerencia" name="tipo" value="sugerencia" checked>
            <label for="sugerencia">Sugerencia</label>
            <input type="radio" id="queja" name="tipo" value="queja">
            <label for="queja">Queja</label>

            <label>¿Has realizado alguna queja o sugerencia anteriormente?:</label>
            <input type="radio" id="previa_si" name="incidencia_previa" value="si">
            <label for="previa_si">Sí</label>
            <input type="radio" id="previa_no" name="incidencia_previa" value="no" checked>
            <label for="previa_no">No</label>

            <div id="seguimiento" style="display:none;">
                <label for="seguimiento">¿Se le dio seguimiento a tu caso anterior?:</label>
                <input type="radio" id="seguimiento_si" name="seguimiento" value="si">
                <label for="seguimiento_si">Sí</label>
                <input type="radio" id="seguimiento_no" name="seguimiento" value="no">
                <label for="seguimiento_no">No</label>
            </div>

                <label for="mensaje">Mensaje (máximo 400 palabras):</label>
                <textarea id="mensaje" name="mensaje" placeholder="Escribe tu mensaje aquí..." maxlength="2400" required></textarea>

            <button type="submit">Enviar</button>
        </fieldset>
    </form>
<!--Este es el script que nos permite desplayar un cuadro de texto en caso de seguimiento, para que se escoja otra opcion -->
    <script>
        document.getElementById('previa_si').addEventListener('change', function() {
            document.getElementById('seguimiento').style.display = 'block';
        });

        document.getElementById('previa_no').addEventListener('change', function() {
            document.getElementById('seguimiento').style.display = 'none';
        });
    </script>
</body>
</html>