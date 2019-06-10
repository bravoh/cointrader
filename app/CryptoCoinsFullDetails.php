<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoCoinsFullDetails extends Model
{
    protected $fillable = ['id', 'title', 'alias', 'seo_description', 'full_name', 'symbol', 'description', 'features', 'technology', 'algorithm', 'proof_type', 'start_date', 'twitter', 'website_url', 'block_number', 'block_time', 'total_coins_mined', 'previous_total_coins_mined', 'block_reward', 'net_hases_per_second', 'ico_status', 'ico_description', 'ico_token_supply', 'ico_start_date', 'ico_end_date', 'ico_fund_raised_btc', 'ico_fund_raised_usd', 'ico_start_price', 'ico_security_audit_company', 'ico_legal_form', 'ico_jurisdiction', 'ico_legal_advisers', 'ico_blog', 'ico_white_paper_link', 'reddit', 'facebook'];
}
