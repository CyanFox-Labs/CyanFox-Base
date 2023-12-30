<?php

return [
    'welcome' => [
        // content, title, subject placeholders: :username, :password, :first_name, :last_name
        'title' => 'Willkommen bei ' . env('APP_NAME'),
        'subject' => 'Willkommen bei ' . env('APP_NAME'),
        'content' => 'Dein Account wurde erfolgreich erstellt. <br><br>
 Deine Zugangsdaten lauten: <br><br>
  Nutzername: :username <br> Passwort: :password <br><br>
  Du kannst dich jetzt hier anmelden: <a href="' . route('login') . '">Anmelden</a>'
    ],
    'forgot_password' => [
        // content, title, subject placeholders: :username, :first_name, :last_name, :reset_link, :password_reset_token
        'title' => 'Passwort zurücksetzen',
        'subject' => 'Passwort zurücksetzen',
        'content' => 'Hallo :first_name :last_name, <br><br>
 Du hast eine Anfrage zum Zurücksetzen deines Passworts gestellt. <br><br>
  Klicke auf den folgenden Link, um dein Passwort zurückzusetzen: <br><br>
  Der Link ist 24 Stunden gültig. <br><br>
  <a href=":reset_link">Passwort zurücksetzen</a> <br><br>
   Wenn du diese Anfrage nicht gestellt hast, kannst du diese E-Mail ignorieren.'
    ]
];
