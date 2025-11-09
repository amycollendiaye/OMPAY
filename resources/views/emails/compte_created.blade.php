<!DOCTYPE html>
<html>
<body>
    <h2>Bonjour {{ $user->prenom }} {{ $user->nom }},</h2>
    <p>Votre compte OMPAY a été créé avec succès 🎉</p>

    <p><strong>Numéro de compte :</strong> {{ $compte->numero_compte }}</p>
    <p><strong>Telephone :</strong> {{ $client->telephone }}</p>
    <p><strong>votre code secret:</strong> {{$client->code_secret}}</p>
        <p>le code secret  de compte   ne doit pas etre partage     pour eviter les  les cas de arnaques 🎉</p>


    <p>Merci de votre confiance,<br>Orange Bank Sénégal</p>
</body>
</html>
