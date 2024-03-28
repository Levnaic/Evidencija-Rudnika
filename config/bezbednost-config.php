<?php
return [
    //regex
    'regexStrPatern' => "/^[a-zA-Z]*$/",
    'regexIntPatern' => '/^[0-9]*$/',
    'regexEmailPatern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
    'regexTxtPatern' => "/^[\s\S]*$/",
    'regexKorisnickoImePatern' => "/^[a-zA-Z0-9._]{1,20}$/",
    'regexDatumPatern' => "/^\d{4}-\d{2}-\d{2}$/",
    'regexFloatPatern' => "/^-?\d*\.?\d+$/",
    // 'regexSifraPatern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*#?&]{8,}$/",
    'regexSifraPatern' => "/[\s\S]*/",
];
