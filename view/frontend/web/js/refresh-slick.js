define([
    'jquery',
    'Magento_Customer/js/customer-data'
], function ($, customerData) {
    'use strict';

    return function () {

        var customer = customerData.get('customer');

        customer.subscribe(function (data) {

            setTimeout(function () {
                try {
                    $('.slick-slider').slick('setPosition');
                } catch (e) {
                }
            }, 400); // pequeno delay para o DOM atualizar
        });
    };
});
