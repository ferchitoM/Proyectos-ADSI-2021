@extends('Plantilla')

@section('titulo')
    {{ 'Perfil' }}
@stop

@section('seccion')

    <div class="container mt-5">

        <div class="row">

            <div class="col-4">
                <label>Información de perfil</label>
                <label><small>Actualice la información de perfil y la dirección de correo electrónico de su
                        cuenta.</small></label>
            </div>

            <div class="col-8">

                <form method="POST" action="{{ route('perfil-datos-admin') }}">

                    @csrf

                    <div class="card text-dark">

                        @if ($errors->Any() && session('datos'))

                            <div class="alert alert-danger m-3">

                                <ul>
                                    @foreach ($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                    @endforeach
                                </ul>

                            </div>

                        @endif

                        @if (session('status-datos'))

                            <div class="alert alert-success m-3">
                                {{ session('status-datos') }}
                            </div>

                        @endif

                        <div class="card-body col-8">

                            <div class="form-group">
                                <label>Documento</label>
                                <input type="number" class="form-control" name="Documento">
                            </div>
                            <div class="form-group">
                                <label>Correo electrónico</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                <small class="form-text text-muted">
                                    No compartiremos su correo electrónico con nadie más.</small>
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-dark">Guardar</button>
                            </div>
                        </div>
                    </div>
                    
                </form>

            </div>
        </div>

        <div class="row mt-5">

            <div class="col-4">
                <label>Actualizar contraseña</label>
                <label><small>Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse
                        seguro.</small></label>
            </div>

            <div class="col-8">

                <form method="POST" action="{{ route('perfil-password') }}" id="formPass">

                    @csrf

                    <div class="card text-dark">

                        <div class="card-body col-8">

                            @if ($errors->Any() && session('pass'))

                                <div class="alert alert-danger m-3">

                                    <ul>
                                        @foreach ($errors->all() as $error)

                                            <li>{{ $error }}</li>

                                        @endforeach
                                    </ul>

                                </div>

                                <script>
                                    //HACE SCROLL HASTA EL FORMULARIO FORMPASS
                                    $(document).ready(function() {
                                        $('html,body').scrollTop($('#formPass').offset().top);
                                    });

                                </script>

                            @endif

                            @if (session('status-password'))

                                <div class="alert alert-success m-3">
                                    {{ session('status-password') }}
                                </div>

                                <script>
                                    //HACE SCROLL HASTA EL FORMULARIO FORMPASS
                                    $(document).ready(function() {
                                        $('html,body').scrollTop($('#formPass').offset().top);
                                    });

                                </script>

                            @endif

                            <div class="form-group">
                                <label>Contraseña actual</label>
                                <input type="password" class="form-control" name="password_vieja">
                            </div>
                            <div class="form-group">
                                <label>Nueva contraseña</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label>Confirmar contraseña</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-dark">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>

        <div class="row mt-5"></div>

    </div>

@stop
