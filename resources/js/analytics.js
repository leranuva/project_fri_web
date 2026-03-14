/**
 * Fase 8: Eventos de analítica (GA4, PostHog)
 * Eventos: quote_calculated, quote_saved, tracking_search, checkout_click, store_redirect
 */
export function trackQuoteCalculated(data) {
    const payload = {
        product: data?.product,
        productName: data?.productName,
        total: data?.totalCotizacion,
        shippingMethod: data?.shippingMethod,
    };
    if (window.gtag) {
        window.gtag('event', 'quote_calculated', payload);
    }
    if (window.posthog) {
        window.posthog.capture('quote_calculated', payload);
    }
}

export function trackQuoteSaved(data) {
    const payload = {
        product: data?.product,
        total: data?.totalCotizacion,
    };
    if (window.gtag) {
        window.gtag('event', 'quote_saved', payload);
    }
    if (window.posthog) {
        window.posthog.capture('quote_saved', payload);
    }
}

export function trackTrackingSearch(trackingNumber) {
    const payload = { tracking_number: trackingNumber };
    if (window.gtag) {
        window.gtag('event', 'tracking_search', payload);
    }
    if (window.posthog) {
        window.posthog.capture('tracking_search', payload);
    }
}

export function trackCheckoutClick(data) {
    const payload = {
        product: data?.product,
        productName: data?.productName,
        total: data?.totalCotizacion,
    };
    if (window.gtag) {
        window.gtag('event', 'checkout_click', payload);
    }
    if (window.posthog) {
        window.posthog.capture('checkout_click', payload);
    }
}

export function trackStoreRedirect(url, data = {}) {
    const payload = { url, ...data };
    if (window.gtag) {
        window.gtag('event', 'store_redirect', payload);
    }
    if (window.posthog) {
        window.posthog.capture('store_redirect', payload);
    }
}
