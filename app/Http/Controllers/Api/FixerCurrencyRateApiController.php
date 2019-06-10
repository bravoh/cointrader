<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\{Controller,CurlCallController};
use App\CurrenciesRates;
class FixerCurrencyRateApiController extends Controller
{
	public $currencies_rates;

	public function __construct()
	{
		$this->currencies_rates = new CurrenciesRates;
	}

	public function getCurrenciesRatesData()
	{
		$icon_flag = $this->getIconAndFlag();
		$currencies_rates = json_decode(CurlCallController::curl('https://openexchangerates.org/api/latest.json?app_id=' . setting('3rdparty.exchange_rates_apikey') . '&base=USD'), true);
        $order = 10;
        if(isset($currencies_rates['error']) && !isset($currencies_rates['rates'])) {
        	return;
        }
        foreach ($currencies_rates['rates'] as $currency => $rate) {
        	if(in_array($currency, ['BSD', 'BTC', 'GGP', 'JEP', 'XAF', 'USD', 'XAG', 'XAU', 'XCD', 'XDR', 'XOF', 'XPD', 'XPF', 'XPT', 'SOS', 'IRR', 'IQD', 'YER'])) {
        		continue;
        	}
        	if(!$this->currencies_rates->where("currency", '=',  $currency)->update(['rate'=> $rate]))
        	{
        		$currency_rates_obj = new CurrenciesRates();
           		$currency_rates_obj->currency = $currency;
           		$currency_rates_obj->rate = $rate; 
           		$currency_rates_obj->icon = isset($icon_flag[$currency]['icon']) ? $icon_flag[$currency]['icon'] : ''; 
           		$currency_rates_obj->flag = isset($icon_flag[$currency]['flag']) ? $icon_flag[$currency]['flag'] : '';
           		$currency_rates_obj->order = $order;
	            $currency_rates_obj->save();
	        }
	        $order = $order + 10;
	    }
	}

	public function getIconAndFlag()
	{
		return [
			'AUD' => ['icon' => '$' , 'flag' => 'au'],
			'BGN' => ['icon' => 'лв' , 'flag' => 'bg'],
			'BRL' => ['icon' => 'R$' , 'flag' => 'br'],
			'CAD' => ['icon' => '$' , 'flag' => 'ca'],
			'CHF' => ['icon' => '₣' , 'flag' => 'ch'],
			'CNY' => ['icon' => '¥' , 'flag' => 'cn'],
			'CZK' => ['icon' => 'Kč' , 'flag' => 'cz'],
			'DKK' => ['icon' => 'kr' , 'flag' => 'dk'],
			'EUR' => ['icon' => '€' , 'flag' => 'eu'],
			'GBP' => ['icon' => '£' , 'flag' => 'gb'],
			'HKD' => ['icon' => '$' , 'flag' => 'hk'],
			'HRK' => ['icon' => 'Kn' , 'flag' => 'hr'],
			'HUF' => ['icon' => 'Ft' , 'flag' => 'hu'],
			'IDR' => ['icon' => 'Rp' , 'flag' => 'id'],
			'ILS' => ['icon' => '₪' , 'flag' => 'il'],
			'INR' => ['icon' => '₹' , 'flag' => 'in'],
			'ISK' => ['icon' => 'Kr' , 'flag' => 'is'],
			'JPY' => ['icon' => '¥' , 'flag' => 'jp'],
			'KRW' => ['icon' => '₩' , 'flag' => 'kr'],
			'MXN' => ['icon' => '$' , 'flag' => 'mx'],
			'MYR' => ['icon' => 'RM' , 'flag' => 'my'],
			'NOK' => ['icon' => 'kr' , 'flag' => 'no'],
			'NZD' => ['icon' => '$' , 'flag' => 'nz'],
			'PHP' => ['icon' => '₱' , 'flag' => 'ph'],
			'PLN' => ['icon' => 'zł' , 'flag' => 'pl'],
			'RON' => ['icon' => 'L' , 'flag' => 'ro'],
			'RUB' => ['icon' => '₽' , 'flag' => 'ru'],
			'SEK' => ['icon' => 'kr' , 'flag' => 'se'],
			'SGD' => ['icon' => '$' , 'flag' => 'sg'],
			'THB' => ['icon' => '฿' , 'flag' => 'th'],
			'TRY' => ['icon' => '₺' , 'flag' => 'tr'],
			'ZAR' => ['icon' => 'R' , 'flag' => 'za'],

			'AED' => ['icon' => 'Dhs' , 'flag' => 'ae'],
			'AFN' => ['icon' => 'Af' , 'flag' => 'af'],
			'ALL' => ['icon' => 'Lek' , 'flag' => 'al'],
			'AMD' => ['icon' => '֏' , 'flag' => 'am'],
			'ANG' => ['icon' => 'ƒ' , 'flag' => 'an'],
			'AOA' => ['icon' => 'Kz' , 'flag' => 'ao'],
			'ARS' => ['icon' => '$' , 'flag' => 'ar'],
			'AWG' => ['icon' => 'ƒ' , 'flag' => 'aw'],
			'AZN' => ['icon' => '₼' , 'flag' => 'az'],
			'BAM' => ['icon' => 'KM' , 'flag' => 'ba'],
			'BBD' => ['icon' => '$' , 'flag' => 'bb'],
			'BDT' => ['icon' => '৳' , 'flag' => 'bd'],
			'BHD' => ['icon' => 'BD' , 'flag' => 'bh'],
			'BIF' => ['icon' => 'FBu' , 'flag' => 'bi'],
			'BMD' => ['icon' => '$' , 'flag' => 'bm'],
			'BND' => ['icon' => 'B$' , 'flag' => 'bn'],
			'BOB' => ['icon' => 'Bs' , 'flag' => 'bo'],
			'BTN' => ['icon' => 'Nu.' , 'flag' => 'bt'],
			'BWP' => ['icon' => 'P' , 'flag' => 'bw'],
			'BYN' => ['icon' => 'Br' , 'flag' => 'by'],
			'BZD' => ['icon' => '$' , 'flag' => 'bz'],
			'CDF' => ['icon' => 'FC' , 'flag' => 'cd'],
			'CLF' => ['icon' => 'UF' , 'flag' => 'cl'],
			'CLP' => ['icon' => '$' , 'flag' => 'cl'],
			'CNH' => ['icon' => '元' , 'flag' => 'cn'],
			'COP' => ['icon' => '$' , 'flag' => 'co'],
			'CRC' => ['icon' => '₡' , 'flag' => 'cr'],
			'CUC' => ['icon' => 'CUC$' , 'flag' => 'cu'],
			'CUP' => ['icon' => '$MN' , 'flag' => 'cu'],
			'CVE' => ['icon' => '$' , 'flag' => 'cv'],
			'DJF' => ['icon' => 'Fdj' , 'flag' => 'dj'],
			'DOP' => ['icon' => 'RD$' , 'flag' => 'do'],
			'DZD' => ['icon' => 'DA' , 'flag' => 'dz'],
			'EGP' => ['icon' => 'E£' , 'flag' => 'eg'],
			'ERN' => ['icon' => 'Nfk' , 'flag' => 'er'],
			'ETB' => ['icon' => 'ብር' , 'flag' => 'et'],
			'FJD' => ['icon' => 'FJ$' , 'flag' => 'fj'],
			'FKP' => ['icon' => '£' , 'flag' => 'fk'],
			'GEL' => ['icon' => 'ლ' , 'flag' => 'ge'],
			'GHS' => ['icon' => 'GH¢' , 'flag' => 'gh'],
			'GIP' => ['icon' => '£' , 'flag' => 'gi'],
			'GMD' => ['icon' => 'D' , 'flag' => 'gm'],
			'GNF' => ['icon' => 'Fr' , 'flag' => 'gn'],
			'GTQ' => ['icon' => 'Q' , 'flag' => 'gt'],
			'GYD' => ['icon' => 'GY$' , 'flag' => 'gy'],
			'HNL' => ['icon' => 'L' , 'flag' => 'hn'],
			'HTG' => ['icon' => 'G' , 'flag' => 'ht'],
			'IMP' => ['icon' => '£' , 'flag' => 'tm'],
			// 'IQD' => ['icon' => 'ع.د' , 'flag' => 'iq'],
			// 'IRR' => ['icon' => 'ریال' , 'flag' => 'ir'],
			'JMD' => ['icon' => '$' , 'flag' => 'jm'],
			'JOD' => ['icon' => 'JD' , 'flag' => 'jo'],
			'KES' => ['icon' => 'K' , 'flag' => 'ke'],
			'KGS' => ['icon' => 'Лв' , 'flag' => 'kg'],
			'KHR' => ['icon' => '៛' , 'flag' => 'kh'],
			'KMF' => ['icon' => 'CF' , 'flag' => 'km'],
			'KPW' => ['icon' => '₩' , 'flag' => 'kp'],
			'KWD' => ['icon' => 'KD' , 'flag' => 'kw'],
			'KYD' => ['icon' => '$' , 'flag' => 'ky'],
			'KZT' => ['icon' => '₸' , 'flag' => 'kz'],
			'LAK' => ['icon' => '₭N' , 'flag' => 'la'],
			'LBP' => ['icon' => 'LL' , 'flag' => 'lb'],
			'LKR' => ['icon' => 'රු' , 'flag' => 'lk'],
			'LRD' => ['icon' => 'L$' , 'flag' => 'lr'],
			'LSL' => ['icon' => 'L' , 'flag' => 'ls'],
			'LYD' => ['icon' => 'LD' , 'flag' => 'ly'],
			'MAD' => ['icon' => 'DH' , 'flag' => 'ma'],
			'MDL' => ['icon' => 'L' , 'flag' => 'md'],
			'MGA' => ['icon' => 'Ar' , 'flag' => 'mg'],
			'MKD' => ['icon' => 'Ден' , 'flag' => 'mk'],
			'MMK' => ['icon' => 'K' , 'flag' => 'mm'],
			'MNT' => ['icon' => '₮' , 'flag' => 'mn'],
			'MOP' => ['icon' => 'MOP$' , 'flag' => 'mo'],
			'MRO' => ['icon' => 'UM' , 'flag' => 'mr'],
			'MRU' => ['icon' => 'UM' , 'flag' => 'mr'],
			'MUR' => ['icon' => '₨' , 'flag' => 'mu'],
			'MVR' => ['icon' => 'Rf' , 'flag' => 'mv'],
			'MWK' => ['icon' => 'MK' , 'flag' => 'mw'],
			'MZN' => ['icon' => 'MT' , 'flag' => 'mz'],
			'NAD' => ['icon' => 'N$' , 'flag' => 'na'],
			'NGN' => ['icon' => '₦' , 'flag' => 'mg'],
			'NIO' => ['icon' => 'C$' , 'flag' => 'ni'],
			'NPR' => ['icon' => 'रू' , 'flag' => 'np'],
			'OMR' => ['icon' => 'OR' , 'flag' => 'om'],
			'PAB' => ['icon' => 'B/.' , 'flag' => 'pa'],
			'PEN' => ['icon' => 'S/' , 'flag' => 'pe'],
			'PGK' => ['icon' => 'K' , 'flag' => 'pg'],
			'PKR' => ['icon' => '₨' , 'flag' => 'pk'],
			'PYG' => ['icon' => '₲' , 'flag' => 'py'],
			'QAR' => ['icon' => 'QR' , 'flag' => 'qa'],
			'RSD' => ['icon' => 'din' , 'flag' => 'rs'],
			'RWF' => ['icon' => 'R₣' , 'flag' => 'rw'],
			'SBD' => ['icon' => 'Si$' , 'flag' => 'sb'],
			'SAR' => ['icon' => 'SR' , 'flag' => 'sa'],
			'SCR' => ['icon' => 'SRe' , 'flag' => 'sc'],
			'SDG' => ['icon' => 'SD' , 'flag' => 'sd'],
			'SHP' => ['icon' => '£' , 'flag' => 'sh'],
			'SLL' => ['icon' => 'Le' , 'flag' => 'sl'],
			// 'SOS' => ['icon' => 'Sh.so.' , 'flag' => 'so'],
			'SRD' => ['icon' => '$' , 'flag' => 'sr'],
			'SSP' => ['icon' => '£' , 'flag' => 'sd'],
			'STD' => ['icon' => 'Db' , 'flag' => 'st'],
			'STN' => ['icon' => 'Db' , 'flag' => 'st'],
			'SVC' => ['icon' => '₡' , 'flag' => 'sv'],
			'SYP' => ['icon' => '£S' , 'flag' => 'sy'],
			'SZL' => ['icon' => 'L' , 'flag' => 'sz'],
			'TJS' => ['icon' => 'ЅM' , 'flag' => 'tj'],
			'TMT' => ['icon' => 'T' , 'flag' => 'tm'],
			'TND' => ['icon' => 'DT' , 'flag' => 'tn'],
			'TOP' => ['icon' => 'T$' , 'flag' => 'to'],
			'TTD' => ['icon' => '$' , 'flag' => 'tt'],
			'TWD' => ['icon' => '$' , 'flag' => 'tw'],
			'TZS' => ['icon' => 'Sh' , 'flag' => 'tz'],
			'UAH' => ['icon' => '₴' , 'flag' => 'ua'],
			'UGX' => ['icon' => 'Sh' , 'flag' => 'ug'],
			'UYU' => ['icon' => '$' , 'flag' => 'uy'],
			'UZS' => ['icon' => 'so\'m' , 'flag' => 'uz'],
			'VEF' => ['icon' => 'Bs' , 'flag' => 've'],
			'VND' => ['icon' => '₫' , 'flag' => 'vn'],
			'VUV' => ['icon' => 'Vt' , 'flag' => 'vu'],
			'WST' => ['icon' => 'T' , 'flag' => 'ws'],
			// 'YER' => ['icon' => 'ریال' , 'flag' => 'ye'],
			'ZMW' => ['icon' => 'ZK' , 'flag' => 'zm'],
			'ZWL' => ['icon' => 'Z$' , 'flag' => 'zw'],
		];
	}
}
