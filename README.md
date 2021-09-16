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


## Instalaçao via composer

Em desenvolvimento !


## Dúvidas/Problemas

Consulte seu supervisor.