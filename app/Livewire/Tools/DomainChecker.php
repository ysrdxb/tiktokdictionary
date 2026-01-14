<?php

namespace App\Livewire\Tools;

use Livewire\Component;
use App\Models\Setting;

class DomainChecker extends Component
{
    public $term;
    public $tlds = [];
    public $hasChecked = false;
    public $isLoading = false;
    public $isEnabled = true;

    // Advanced options/state
    public $alternates = [];
    public $lastCheckedAt = null;

    public function mount($term)
    {
        // Sanitize term: remove spaces, special chars, lowercase
        $this->term = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $term));

        // Load TLDs from settings (comma-separated)
        $tldsSetting = Setting::get('domain_tlds', 'com,io,co,xyz,app,dev');
        $this->tlds = array_values(array_filter(array_map('trim', explode(',', $tldsSetting))));

        // Check if domain checker is enabled
        $this->isEnabled = Setting::get('domain_checker_enabled', 'true') === 'true';

        // Prepare suggested alternates (no UI overhaul)
        $this->alternates = $this->buildAlternates($this->term);

        // Restore last checked time (session-scoped)
        $this->lastCheckedAt = session()->get($this->sessionKey('last_checked_at'));
    }

    public function check()
    {
        $this->isLoading = true;

        // Simulate API delay for dramatic effect
        // In production, optionally call a cached availability microservice.

        // Mark checked
        $this->hasChecked = true;
        $this->isLoading = false;
        $this->lastCheckedAt = now()->toDateTimeString();
        session()->put($this->sessionKey('last_checked_at'), $this->lastCheckedAt);
    }

    protected function sessionKey($key)
    {
        return 'domain_checker:' . $this->term . ':' . $key;
    }

    protected function buildAlternates(string $term): array
    {
        // Provide subtle alternates the user can try via affiliate link
        $alts = [];
        // hyphenation between common syllable splits (basic heuristic)
        if (strlen($term) > 6) {
            $mid = (int) floor(strlen($term) / 2);
            $alts[] = substr($term, 0, $mid) . '-' . substr($term, $mid);
        }
        // remove trailing vowels for brandy variants
        $alts[] = rtrim($term, 'aeiou');
        // append "hq" or "app" variants
        $alts[] = $term . 'hq';
        $alts[] = $term . 'app';
        // unique, trimmed
        return array_values(array_unique(array_filter($alts, function ($v) use ($term) {
            return $v && $v !== $term;
        })));
    }

    /**
     * Get affiliate URL for a specific TLD.
     */
    public function getAffiliateUrl($tld, $overrideTerm = null)
    {
        $affiliateId = Setting::get('godaddy_affiliate_id', '');
        $domain = $overrideTerm ? strtolower(preg_replace('/[^a-zA-Z0-9-]/', '', $overrideTerm)) : $this->term;
        $url = "https://www.godaddy.com/domainsearch/find?checkAvail=1&domainToCheck={$domain}.{$tld}";

        // UTM/tracking params
        $utm = http_build_query([
            'utm_source' => 'tiktokdictionary',
            'utm_medium' => 'affiliate',
            'utm_campaign' => 'domain-checker',
        ]);
        $url .= "&{$utm}";

        if (!empty($affiliateId)) {
            $url .= "&isc={$affiliateId}";
        }

        return $url;
    }

    public function render()
    {
        return view('livewire.tools.domain-checker');
    }
}
