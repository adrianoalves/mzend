<?php


/**
 * FormatMoney: Monetary test formater
 * para usa-lo dentro de um view script, use $this->nomeHelper, onde nomeHelper eh
 * igual ao nome da funcao e nome da classe em CamelCase precedido do sufixo padrao ou
 * fornecido no segundo parametro de Zend_View -> addHelperPath
 *
 * @author Adriano Alves
 */
class Zend_View_Helper_FormatMoney extends Zend_View_Helper_Abstract{

    public function formatMoney( $var ){
        
       return 'R$ '.trim( $var );
    }

}
?>
