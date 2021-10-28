# Ocultar preços para cliente não logado na loja.


## Requisitos

* Pasta BUZZ dentro da app/code (obrigatorio),
* Preferencialmente modulo *Base* instalado (nao obrigatorio),

## Compatibilidade

- [x] Testado em Magento 2.2.x
- [x] Testado em Magento 2.3.x
- [x] Testado em Magento 2.4.1

## Instalaçao Manual:

1 -> Certifique-se que a loja encontre-se em modo produção,

2 -> Clone este repositório para dentro da sua pasta app/code/Buzz/

3 -> Renomeie a pasta retirando o Buzz- deixando apenas o Hideprice no nome

4 -> A disposição dos arquivos deve ficar dessa maneira: app/code/Buzz/Hideprice

5 -> Execute o comando:

```

bin/magento setup:upgrade

```

Posteriormente execute o comando:

```

bin/magento setup:di:compile 

```
## Configuração:

6 -> Acesse o painel Magento;

7 -> Acesse o seguinte diretório: 

    LOJAS > CONFIGURAÇÃO > BUZZ > Ocultar preço

    e/ou

    STORES > CONFIGURATION > BUZZ > Hide price

8 -> Altere o status de ENABLE para YES | HABILITADO para SIM

![1-opcaomenu](https://github.com/Buzz-Dev-Web/Hideprice/blob/main/images/1-habilitar.png)

9 -> Preencha o campo abaixo da função de habilitar com o texto que deseja que seja exibido no frontend (visão cliente).

![1-textofront](https://github.com/Buzz-Dev-Web/Hideprice/blob/main/images/2-habilitado.png)

10 -> Limpe o cache da loja.

11 -> No frontend o resultado esperado é:

![3-visãocliente](https://github.com/Buzz-Dev-Web/Hideprice/blob/main/images/3-visaocliente.png)

## Instalaçao via composer

Em desenvolvimento !


## Dúvidas/Problemas

Consulte seu supervisor.