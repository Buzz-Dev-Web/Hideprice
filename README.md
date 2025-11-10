# Hideprice - BUZZ

O propósito desse módulo é desabilitar/ocultar o preço quando o cliente não estiver logado com isso garantindo maior sigilo nas informações disponibilizadas, este recurso geralmente é muito utilizado por clientes que trabalham na modalidade B2B e ou que atuam no segmento do Agro.

## Requisitos

* Pasta BUZZ dentro da app/code (obrigatório),
* Módulo *Base* instalado (obrigatório),

## Compatibilidade

- [x] Testado em Magento 2.4.x

## Instalaçao Manual:

1 -> Certifique-se que a loja encontre-se em modo desenvolvimento,

2 -> Clone este repositório para dentro da sua pasta app/code/Buzz/

3 -> Renomeie a pasta retirando o Buzz- deixando apenas o Hideprice no nome

4 -> A disposição dos arquivos deve ficar dessa maneira: app/code/Buzz/Hideprice

5 -> Habilite o módulo através do comando:

```

bin/magento module:enable Buzz_Hideprice

```

6 -> Para atualizar a loja o comando:

```

bin/magento setup:upgrade

```

Posteriormente execute o comando:

```

bin/magento setup:di:compile 

```

7 -> O módulo já está instalado e dispensa configuração, porém no menu do módulo existe o indicador de versão em...

PAINEL MAGENTO -> LOJAS -> CONFIGURACAO -> BUZZ -> OCULTAR PREÇO


**OBS:** Dica, pode executar:

    require(['Magento_Customer/js/customer-data'], function (customerData) {
        console.log(customerData.get('customer')());
    });

No console para debugar se cliente logado/deslogado, o retorno deve ser:

    {firstname: ...} → logado
    {} → guest

### Instalação via Composer:

Em desenvolvimento !


## Dúvida/Suporte:

Em caso de dúvidas entre em contato com o dept de suporte.