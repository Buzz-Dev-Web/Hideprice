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

        return '<p style="font-size: 18px; font-weight: 600; margin-top: 15px;">Informações Gerais</p>
    <br>
    <p>Versão: 2.1</p>
    <br>
    <p>Este módulo têm como objetivo permitir ocultar/desabilitar o preço e a opção de adicionar ao carrinho quando o cliente não estiver logado, funcionalidade utilizado muito em lojas B2B.</p>
    <br>
    <p>Caso ainda houver dúvidas, não se preocupe fale com o suporte !</p>
    <br>
    <p>Desenvolvido por <a href="https://sitedabuzz.com.br" target="_blank" title="Somos apaixonados por Lojas Virtuais">BUZZ</a>.</p>
    ';

    }
}