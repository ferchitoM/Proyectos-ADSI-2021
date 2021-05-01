<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"-->

    <link href="{{ asset('css/app/tailwind.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/certificado.css') }}" rel="stylesheet">

</head>

<body class="bg-gray-500 mt-10">

    <div id="pdf" class="ml-1">

        <div class="container mt-3 mx-auto bg-white box-content border-4 border-gray-400">
            <div class="container bg-gradient-to-r from-purple-900 via-red-900 to-pink-500 h-40 pt-9">
                <p class="font-sans text-7xl text-center text-white">Certificado</p>
            </div>

            <div class="grid grid-cols-6 mb-7">

                <div style="border: 0px solid red">
                    <div class="medalla"></div>
                    <div class="firma1">
                        <img src="{{ asset('imagenes/firma.jpg') }}" alt="">
                        <div class="texto-firma1">
                            <p class="font-sans text-md">Miguel F. Marlés</p>
                            <p class="font-sans text-xs">Instructor Tecnólogo ADSI</p>
                            <p class="font-sans text-xs">SENA C.T. de la Amazonía</p>
                        </div>
                    </div>
                </div>

                <div class="col-start-2 col-span-4" style="border: 0px solid blue">

                    <div class="container text-center mt-7">
                        <span class="font-sans italic text-5xl text-pink-400">SIREV</span>
                        <span class="font-sans text-5xl text-purple-900 font-extrabold">_</span>
                        <span class="font-sans italic text-5xl text-green-400">SENA CTA</span>
                        <p class="font-sans text-md mt-7">Otorga el presente certificado a:</p>
                        <p class="font-sans text-4xl text-gray-600 mt-7">
                            {{ $aprendiz->Nombres . ' ' . $aprendiz->Primer_Apellido . ' ' . $aprendiz->Segundo_Apellido }}
                        </p>
                        <p class="font-sans text-md mt-7">Por haber concluido satisfactoriamente el curso:</p>
                        <p class="font-sans text-2xl text-gray-600 mt-7">RECORRIDO VIRTUAL AL SENA CTA</p>
                        <p class="font-sans text-md mt-7">Fecha de expedición: 10-10-2021</p>
                        <p class="font-sans text-md mb-7">Duración del curso: 4 hrs. académicas</p>
                        <p class="font-sans text-xs mb-7">Certificado #3186-9674</p>

                    </div>

                </div>

                <div style="border: 0px solid red">
                    <div class="firma2">
                        <div class="texto-firma2">
                            <img src="{{ asset('imagenes/firma.jpg') }}" alt="">
                            <p class="font-sans text-md">Miguel F. Marlés</p>
                            <p class="font-sans text-xs">Instructor Tecnólogo ADSI</p>
                            <p class="font-sans text-xs">SENA C.T. de la Amazonía</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="flex flex-row justify-center space-x-10">
        <div class="w-80 h-20 bg-blue-600 mt-10 pt-4 rounded-lg" onclick="descargar_certificado()">
            <a href="#" class="ml-20 pl-3">
                <span class="font-sans text-4xl text-white">Descargar</span>
            </a>
        </div>

        <div class="w-80 h-20 bg-gray-700 mt-10 pt-4 rounded-lg">
            <a href="{{ route('app-index') }}" class="ml-20 pl-3">
                <span class="font-sans text-4xl text-white">Regresar</span>
            </a>
        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <script src="{{ asset('Helpers/html2pdf.bundle.js') }}"></script>
    <script src="{{ asset('Helpers/generarPDF.js') }}"></script>

    <script>

        //CREAMOS LA VARIABLE DONDE VAMOS A GUARDAR EL PDF
        var pdf = null;

        $(document).ready(function() {

            //RECIBIMOS EL PDF EN UNA VARIABLE
            pdf = generarPDF('pdf');

        });

        function descargar_certificado() {

            //LLAMAMOS A LA FUNCION save() PARA DESCARGAR EL PDF
            pdf.save();
        }

    </script>

</body>

</html>
