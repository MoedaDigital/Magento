<?php
/**
 *
 * MoedaDigital 
 *
 **/
class MoedaDigital_Model_Source_NivelRisco {

    public function toOptionArray() {
        return array(
            'indefinido' => 'Indefinido - Não sei informar',
            'baixo' => 'Baixo - Menor que 3% do faturamento',
            'medio' => 'Médio - Menor que 10% do faturamento',
            'alto' => 'Alto - Maior que 10% do faturamento',
        );
    }
}
