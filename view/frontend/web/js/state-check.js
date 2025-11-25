define([
    'jquery',
    'Magento_Customer/js/customer-data'
], function ($, customerData) {
    'use strict';

    return function () {

        var retries = 0;
        var maxRetries = 15;

        function check() {
            var customer = customerData.get('customer')();

            // Aguarda seção carregar
            if (!customer || $.isEmptyObject(customer)) {
                retries++;

                if (retries < maxRetries) {
                    setTimeout(check, 400);
                }
                return;
            }

            var isLoggedBySection = !!(customer.firstname || customer.email);
            var body = document.body;

            var hasGuestClass = body.classList.contains('buzz-guest');
            var hasLoggedClass = body.classList.contains('buzz-logged-in');

            if (isLoggedBySection && hasGuestClass) {
                window.location.reload(true);
                return;
            }

            if (!isLoggedBySection && hasLoggedClass) {
                window.location.reload(true);
                return;
            }

        }

        $(check);
    };
});