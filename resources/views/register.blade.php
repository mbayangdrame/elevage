<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app') {{-- Assurez-vous d'ajuster le nom de la mise en page en conséquence --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inscription') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="image">Image de profil</label>
                            <input type="file" name="image" id="image">
                        </div>

                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" name="prenom" id="prenom" required>
                        </div>

                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" id="nom" required>
                        </div>

                        <div class="form-group">
                            <label for="adresse">Adresse</label>
                            <input type="text" name="adresse" id="adresse" required>
                        </div>

                        <div class="form-group">
                            <label for="NumeroTelephone">Numéro de téléphone</label>
                            <input type="text" name="NumeroTelephone" id="NumeroTelephone" required>
                        </div>

                        <div class="form-group">
                            <label for="profil">Profil</label>
                            <input type="text" name="profil" id="profil" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Adresse e-mail</label>
                            <input type="email" name="email" id="email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" id="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('S\'inscrire') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

</body>
</html>