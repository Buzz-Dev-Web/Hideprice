<?php

/**
 * @package   Buzz_Hideprice
 * @author    github.com/mauricio-tonny
 * @copyright Copyright (c)
 */

namespace Buzz\Hideprice\Block\Adminhtml\System\Config;

class Documentation extends \Magento\Config\Block\System\Config\Form\Fieldset
{
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {

        return '<p style="font-size: 18px; font-weight: 600; margin-top: 20px;">Informações para o DEV</p>
    <br>
    <p>Versão: 1.5</p>
    <br>
    <p>Este módulo destina-se a ocultar o valor do produto para cliente que não estiver logado.</p> 
    <br>
    <div style="padding: 20px; border: solid 1px #000; background: #eee;">
        <br>
        <p style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Próximas atualizações: </p>
        <p>- Ocultar também simulações das parcelas (Buzz_Installments),</p>
        <p>- Otimizar a velocidade de loading dos preços quando cliente logado,</p>
        <p></p>
        <br>
    </div>
    <br>
    <p>Caso ainda houver dúvidas, não se preocupe fale com o suporte !</p>
    <br>
    <p>Desenvolvido por <a href="https://sitedabuzz.com.br" target="_blank" title="Somos apaixonados por Lojas Virtuais">BUZZ</a>.</p>
    ';

    }
}
