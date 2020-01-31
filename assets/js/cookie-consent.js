window.addEventListener("load", function () {
    window.cookieconsent.initialise({
        "palette": {
            "popup": {
                "background": "#ffffff",
                "text": "#484848"
            },
            "button": {
                "background": "#000000",
                "text": "#fff"
            }
        },
        "position": "bottom-right",
        "type": "opt-in",
        "content": {
            "message": "This website uses cookies to enhance your experience.",
            "allow": "Allow",
            "deny": "Deny",
            "link": ""
        },
        onInitialise: function (status) {
            var type = this.options.type;
            var didConsent = this.hasConsented();
            if (type == 'opt-in' && didConsent) {
                dataLayer.push({
                    'cookieConsent': 'allowed',
                    'event': 'cookieConsentAllowed'
                });
            }
            if (type == 'opt-out' && !didConsent) {
                dataLayer.push({
                    'cookieConsent': 'dismissed',
                    'event': 'cookieConsentDismissed'
                });
            }
        },
        onStatusChange: function (status, chosenBefore) {
            var type = this.options.type;
            var didConsent = this.hasConsented();
            if (type == 'opt-in' && didConsent) {
                dataLayer.push({
                    'cookieConsent': 'allowed',
                    'event': 'cookieConsentAllowed'
                });
            }
            if (type == 'opt-out' && !didConsent) {
                dataLayer.push({
                    'cookieConsent': 'dismissed',
                    'event': 'cookieConsentDismissed'
                });
            }
        }
    })
});