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

    public function mount($term)
    {
        // Sanitize term: remove spaces, special chars, lowercase
        $this->term = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $term));

        // Load TLDs from settings
        $tldsSetting = Setting::get('domain_tlds', 'com,io,co,xyz');
        $this->tlds = array_map('trim', explode(',', $tldsSetting));

        // Check if domain checker is enabled
        $this->isEnabled = Setting::get('domain_checker_enabled', 'true') === 'true';
    }

    public function check()
    {
        $this->isLoading = true;

        // Simulate API delay for dramatic effect
        // In real world, we might verify availability via API
        // For MVP/Affiliate model, we just push them to GoDaddy search

        $this->hasChecked = true;
        $this->isLoading = false;
    }

    /**
     * Get affiliate URL for a specific TLD.
     */
    public function getAffiliateUrl($tld)
    {
        $affiliateId = Setting::get('godaddy_affiliate_id', '');
        $domain = $this->term;
        $url = "https://www.godaddy.com/domainsearch/find?checkAvail=1&domainToCheck={$domain}.{$tld}";

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
