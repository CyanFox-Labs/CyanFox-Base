<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validierungs-Sprachzeilen
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen enthalten die Standard-Fehlermeldungen, die
    | von der Validator-Klasse verwendet werden. Einige dieser Regeln haben
    | mehrere Versionen, wie die Größenregeln. Fühle dich frei, jede dieser
    | Nachrichten hier anzupassen.
    |
    */

    'accepted' => 'Dieses Feld muss akzeptiert werden.',
    'accepted_if' => 'Dieses Feld muss akzeptiert werden, wenn :other :value ist.',
    'active_url' => 'Dieses Feld muss eine gültige URL sein.',
    'after' => 'Dieses Feld muss ein Datum nach :date sein.',
    'after_or_equal' => 'Dieses Feld muss ein Datum nach oder gleich :date sein.',
    'alpha' => 'Dieses Feld darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Dieses Feld darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => 'Dieses Feld darf nur Buchstaben und Zahlen enthalten.',
    'array' => 'Dieses Feld muss ein Array sein.',
    'ascii' => 'Dieses Feld darf nur einbyte alphanumerische Zeichen und Symbole enthalten.',
    'before' => 'Dieses Feld muss ein Datum vor :date sein.',
    'before_or_equal' => 'Dieses Feld muss ein Datum vor oder gleich :date sein.',
    'between' => [
        'array' => 'Dieses Feld muss zwischen :min und :max Elemente haben.',
        'file' => 'Dieses Feld muss zwischen :min und :max Kilobytes groß sein.',
        'numeric' => 'Dieses Feld muss zwischen :min und :max liegen.',
        'string' => 'Dieses Feld muss zwischen :min und :max Zeichen lang sein.',
    ],
    'boolean' => 'Dieses Feld muss wahr oder falsch sein.',
    'can' => 'Dieses Feld enthält einen nicht autorisierten Wert.',
    'confirmed' => 'Die Bestätigung dieses Feldes stimmt nicht überein.',
    'contains' => 'Dieses Feld fehlt ein erforderlicher Wert.',
    'current_password' => 'Das Passwort ist falsch.',
    'date' => 'Dieses Feld muss ein gültiges Datum sein.',
    'date_equals' => 'Dieses Feld muss ein Datum gleich :date sein.',
    'date_format' => 'Dieses Feld muss dem Format :format entsprechen.',
    'decimal' => 'Dieses Feld muss :decimal Dezimalstellen haben.',
    'declined' => 'Dieses Feld muss abgelehnt werden.',
    'declined_if' => 'Dieses Feld muss abgelehnt werden, wenn :other :value ist.',
    'different' => 'Dieses Feld und :other müssen unterschiedlich sein.',
    'digits' => 'Dieses Feld muss :digits Stellen haben.',
    'digits_between' => 'Dieses Feld muss zwischen :min und :max Stellen haben.',
    'dimensions' => 'Dieses Feld hat ungültige Bildabmessungen.',
    'distinct' => 'Dieses Feld hat einen doppelten Wert.',
    'doesnt_end_with' => 'Dieses Feld darf nicht mit einem der folgenden enden: :values.',
    'doesnt_start_with' => 'Dieses Feld darf nicht mit einem der folgenden beginnen: :values.',
    'email' => 'Dieses Feld muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Dieses Feld muss mit einem der folgenden enden: :values.',
    'enum' => 'Der ausgewählte Wert ist ungültig.',
    'exists' => 'Der ausgewählte Wert ist ungültig.',
    'extensions' => 'Dieses Feld muss eine der folgenden Erweiterungen haben: :values.',
    'file' => 'Dieses Feld muss eine Datei sein.',
    'filled' => 'Dieses Feld muss einen Wert haben.',
    'gt' => [
        'array' => 'Dieses Feld muss mehr als :value Elemente haben.',
        'file' => 'Dieses Feld muss größer als :value Kilobytes sein.',
        'numeric' => 'Dieses Feld muss größer als :value sein.',
        'string' => 'Dieses Feld muss länger als :value Zeichen sein.',
    ],
    'gte' => [
        'array' => 'Dieses Feld muss mindestens :value Elemente haben.',
        'file' => 'Dieses Feld muss größer oder gleich :value Kilobytes sein.',
        'numeric' => 'Dieses Feld muss größer oder gleich :value sein.',
        'string' => 'Dieses Feld muss größer oder gleich :value Zeichen sein.',
    ],
    'hex_color' => 'Dieses Feld muss eine gültige hexadezimale Farbe sein.',
    'image' => 'Dieses Feld muss ein Bild sein.',
    'in' => 'Der ausgewählte Wert ist ungültig.',
    'in_array' => 'Dieses Feld muss in :other existieren.',
    'integer' => 'Dieses Feld muss eine ganze Zahl sein.',
    'ip' => 'Dieses Feld muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Dieses Feld muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Dieses Feld muss eine gültige IPv6-Adresse sein.',
    'json' => 'Dieses Feld muss ein gültiger JSON-String sein.',
    'list' => 'Dieses Feld muss eine Liste sein.',
    'lowercase' => 'Dieses Feld muss klein geschrieben sein.',
    'lt' => [
        'array' => 'Dieses Feld muss weniger als :value Elemente haben.',
        'file' => 'Dieses Feld muss kleiner als :value Kilobytes sein.',
        'numeric' => 'Dieses Feld muss kleiner als :value sein.',
        'string' => 'Dieses Feld muss kürzer als :value Zeichen sein.',
    ],
    'lte' => [
        'array' => 'Dieses Feld darf nicht mehr als :value Elemente haben.',
        'file' => 'Dieses Feld muss kleiner oder gleich :value Kilobytes sein.',
        'numeric' => 'Dieses Feld muss kleiner oder gleich :value sein.',
        'string' => 'Dieses Feld muss kleiner oder gleich :value Zeichen sein.',
    ],
    'mac_address' => 'Dieses Feld muss eine gültige MAC-Adresse sein.',
    'max' => [
        'array' => 'Dieses Feld darf nicht mehr als :max Elemente haben.',
        'file' => 'Dieses Feld darf nicht größer als :max Kilobytes sein.',
        'numeric' => 'Dieses Feld darf nicht größer als :max sein.',
        'string' => 'Dieses Feld darf nicht länger als :max Zeichen sein.',
    ],
    'max_digits' => 'Dieses Feld darf nicht mehr als :max Stellen haben.',
    'mimes' => 'Dieses Feld muss eine Datei des Typs sein: :values.',
    'mimetypes' => 'Dieses Feld muss eine Datei des Typs sein: :values.',
    'min' => [
        'array' => 'Dieses Feld muss mindestens :min Elemente haben.',
        'file' => 'Dieses Feld muss mindestens :min Kilobytes groß sein.',
        'numeric' => 'Dieses Feld muss mindestens :min sein.',
        'string' => 'Dieses Feld muss mindestens :min Zeichen lang sein.',
    ],
    'min_digits' => 'Dieses Feld muss mindestens :min Stellen haben.',
    'missing' => 'Dieses Feld muss fehlen.',
    'missing_if' => 'Dieses Feld muss fehlen, wenn :other :value ist.',
    'missing_unless' => 'Dieses Feld muss fehlen, es sei denn, :other ist :value.',
    'missing_with' => 'Dieses Feld muss fehlen, wenn :values vorhanden ist.',
    'missing_with_all' => 'Dieses Feld muss fehlen, wenn :values vorhanden sind.',
    'multiple_of' => 'Dieses Feld muss ein Vielfaches von :value sein.',
    'not_in' => 'Der ausgewählte Wert ist ungültig.',
    'not_regex' => 'Das Format dieses Feldes ist ungültig.',
    'numeric' => 'Dieses Feld muss eine Zahl sein.',
    'password' => [
        'letters' => 'Dieses Feld muss mindestens einen Buchstaben enthalten.',
        'mixed' => 'Dieses Feld muss mindestens einen Groß- und einen Kleinbuchstaben enthalten.',
        'numbers' => 'Dieses Feld muss mindestens eine Zahl enthalten.',
        'symbols' => 'Dieses Feld muss mindestens ein Symbol enthalten.',
        'uncompromised' => 'Der angegebene Wert ist in einem Datenleck aufgetaucht. Bitte wähle einen anderen Wert.',
        'blacklist' => 'Der angegebene Wert ist nicht erlaubt. Bitte wähle einen anderen Wert.',
    ],
    'present' => 'Dieses Feld muss vorhanden sein.',
    'present_if' => 'Dieses Feld muss vorhanden sein, wenn :other :value ist.',
    'present_unless' => 'Dieses Feld muss vorhanden sein, es sei denn, :other ist :value.',
    'present_with' => 'Dieses Feld muss vorhanden sein, wenn :values vorhanden ist.',
    'present_with_all' => 'Dieses Feld muss vorhanden sein, wenn :values vorhanden sind.',
    'prohibited' => 'Dieses Feld ist verboten.',
    'prohibited_if' => 'Dieses Feld ist verboten, wenn :other :value ist.',
    'prohibited_unless' => 'Dieses Feld ist verboten, es sei denn, :other ist in :values.',
    'prohibits' => 'Dieses Feld verbietet das Vorhandensein von :other.',
    'regex' => 'Das Format dieses Feldes ist ungültig.',
    'required' => 'Dieses Feld ist erforderlich.',
    'required_array_keys' => 'Dieses Feld muss Einträge für enthalten: :values.',
    'required_if' => 'Dieses Feld ist erforderlich, wenn :other :value ist.',
    'required_if_accepted' => 'Dieses Feld ist erforderlich, wenn :other akzeptiert wird.',
    'required_if_declined' => 'Dieses Feld ist erforderlich, wenn :other abgelehnt wird.',
    'required_unless' => 'Dieses Feld ist erforderlich, es sei denn, :other ist in :values.',
    'required_with' => 'Dieses Feld ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => 'Dieses Feld ist erforderlich, wenn :values vorhanden sind.',
    'required_without' => 'Dieses Feld ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Dieses Feld ist erforderlich, wenn keiner der :values vorhanden ist.',
    'same' => 'Dieses Feld muss mit :other übereinstimmen.',
    'size' => [
        'array' => 'Dieses Feld muss :size Elemente enthalten.',
        'file' => 'Dieses Feld muss :size Kilobytes groß sein.',
        'numeric' => 'Dieses Feld muss :size sein.',
        'string' => 'Dieses Feld muss :size Zeichen lang sein.',
    ],
    'starts_with' => 'Dieses Feld muss mit einem der folgenden beginnen: :values.',
    'string' => 'Dieses Feld muss ein String sein.',
    'timezone' => 'Dieses Feld muss eine gültige Zeitzone sein.',
    'unique' => 'Dieser Wert ist bereits vergeben.',
    'uploaded' => 'Das Hochladen dieses Feldes ist fehlgeschlagen.',
    'uppercase' => 'Dieses Feld muss groß geschrieben sein.',
    'url' => 'Dieses Feld muss eine gültige URL sein.',
    'ulid' => 'Dieses Feld muss eine gültige ULID sein.',
    'uuid' => 'Dieses Feld muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Benutzerdefinierte Validierungs-Sprachzeilen
    |--------------------------------------------------------------------------
    |
    | Hier kannst du benutzerdefinierte Validierungsnachrichten für Attribute
    | angeben, indem du die Konvention "attribute.rule" verwendest, um die
    | Zeilen zu benennen. Dies ermöglicht es schnell, eine spezifische
    | benutzerdefinierte Sprachzeile für eine bestimmte Attributregel
    | anzugeben.
    |
    */

    'custom' => [
        'invalid_captcha' => 'Das Captcha ist ungültig.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Benutzerdefinierte Validierungs-Attribute
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen werden verwendet, um Platzhalter für Attribute
    | durch etwas Leserfreundlicheres zu ersetzen, wie zum Beispiel "E-Mail-Adresse"
    | anstelle von "email". Dies hilft uns, unsere Nachricht ausdrucksvoller zu gestalten.
    |
    */

    'attributes' => [],

];
