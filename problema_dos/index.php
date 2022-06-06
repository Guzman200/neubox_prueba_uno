<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Problema dos</title>
</head>

<body>


    <div class="container mt-4">

        <form>
            <div class="form-group">
                <label for="exampleFormControlInput1">Archivo de texto</label>
                <input type="file" class="form-control" id="archivo" placeholder="name@example.com">
            </div>
            <div class="form-group">
                <button id="btnObtenerResultados" type="button" class="btn btn-success">
                    Obtener resultado
                </button>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Resultado final</label>
                <textarea class="form-control" id="resultado" rows="3"></textarea>
            </div>
        </form>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script>

        

        document.getElementById('btnObtenerResultados').addEventListener('click', async function(){

            let inputArchivo = document.getElementById('archivo');
            let archivo = "";

            if(inputArchivo.files && inputArchivo.files[0]){
                archivo = inputArchivo.files[0];
            }


            if(archivo){
                if(archivo.type == "text/plain"){

                    let data = new FormData();
                    data.append('archivo', archivo);
                    
                    let peticion = await fetch('procesar.php', {
                        method : 'POST',
                        body : data
                    })

                    let response = await peticion.json();

                    console.log(response);
                    document.getElementById('resultado').value = response.resultado

                    window.location.href = 'descargar.php';

                    inputArchivo.value = '';

                }
            }

        })


    </script>

   
    
</body>

</html>