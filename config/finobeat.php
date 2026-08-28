<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Comissão (split de cachê)
    |--------------------------------------------------------------------------
    |
    | Percentuais padrão aplicados sobre o valor do cachê de um show. A empresa
    | retém "company_cut_percent" do cachê; desse total, "manager_cut_percent"
    | (pontos percentuais sobre o cachê) remunera o Artist Manager que fechou o
    | show e o restante fica com a empresa. O mesmo "company_cut_percent" vale
    | para os rendimentos de streaming (sem participação de manager).
    |
    | Estes valores são "congelados" (snapshot) em cada show/rendimento no
    | momento do cadastro, para que alterações futuras não reescrevam o
    | histórico financeiro.
    |
    */

    'commission' => [
        'company_cut_percent' => 30,
        'manager_cut_percent' => 10,
    ],

];
