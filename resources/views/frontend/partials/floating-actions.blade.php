@php
    $socialLinks = ($footerLinks ?? collect())->get('social', collect());

    $resolveFloatingUrl = static function ($link): ?string {
        if (! $link) {
            return null;
        }

        if ($link->route_name && \Illuminate\Support\Facades\Route::has($link->route_name)) {
            return route($link->route_name);
        }

        return $link->custom_url ?: null;
    };

    $findSocialLink = static function (string $keyword) use ($socialLinks) {
        return $socialLinks->first(function ($link) use ($keyword) {
            return str_contains(
                strtolower(trim((string) $link->label)),
                strtolower($keyword)
            );
        });
    };

    $whatsappUrl = $siteSetting->whatsapp_url
        ?: $resolveFloatingUrl($findSocialLink('whatsapp'));

    $instagramUrl = $resolveFloatingUrl($findSocialLink('instagram'));

    $messageLink = $findSocialLink('messenger')
        ?: $findSocialLink('message');

    $messageUrl = $resolveFloatingUrl($messageLink);

    if (! $messageUrl && $siteSetting->contact_email) {
        $messageUrl = 'mailto:'.$siteSetting->contact_email;
    }
@endphp

<div class="floating-tools">
    <div class="floating-social" data-floating-social>
        <div
            class="floating-social-items"
            data-floating-items
            aria-hidden="true"
        >
            @if($messageUrl)
                <a
                    href="{{ $messageUrl }}"
                    class="floating-action floating-action-message"
                    aria-label="Message"
                    title="Message"
                    @if($messageLink?->open_new_tab) target="_blank" rel="noopener" @endif
                >
                    <i class="fas fa-envelope"></i>
                </a>
            @endif

            @if($whatsappUrl)
                <a
                    href="{{ $whatsappUrl }}"
                    class="floating-action floating-action-whatsapp"
                    target="_blank"
                    rel="noopener"
                    aria-label="WhatsApp"
                    title="WhatsApp"
                >
                    <i class="fab fa-whatsapp"></i>
                </a>
            @endif

            @if($instagramUrl)
                <a
                    href="{{ $instagramUrl }}"
                    class="floating-action floating-action-instagram"
                    target="_blank"
                    rel="noopener"
                    aria-label="Instagram"
                    title="Instagram"
                >
                    <i class="fab fa-instagram"></i>
                </a>
            @endif
        </div>

        <button
            type="button"
            class="floating-action floating-action-toggle"
            data-floating-toggle
            aria-expanded="false"
            aria-label="Open contact shortcuts"
            title="Contact shortcuts"
        >
            <i class="fas fa-plus"></i>
        </button>
    </div>

    <button
        type="button"
        class="floating-back-to-top"
        data-back-to-top
        aria-label="Back to top"
        title="Back to top"
    >
        <i class="fas fa-chevron-up"></i>
    </button>
</div>

