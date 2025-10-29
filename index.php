<?php
/**
 * KD - Domain Check System
 * Advanced Multi-Language Domain Availability Checker
 * 
 * @version 1.0.0
 * @author Egemen KEYDAL
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'tr';

$translations = [
    'tr' => [
        'site_title' => 'KD - Alan Adı Sorgu',
        'site_subtitle' => 'Profesyonel alan adı sorgulama sistemi',
        'domain_input_label' => 'Alan Adı veya Alan Adı İsmi',
        'domain_input_placeholder' => 'ornek.com veya sadece ornek',
        'search_button' => 'Sorgula',
        'registered' => 'Kayıtlı',
        'available' => 'Müsait',
        'domain_status' => 'Alan Adı Durumu',
        'creation_date' => 'Oluşturma Tarihi',
        'expiration_date' => 'Bitiş Tarihi',
        'registrar' => 'Kayıt Şirketi',
        'nameservers' => 'Alan Adı Sunucuları',
        'show_details' => 'Detayları Göster',
        'raw_whois' => 'Ham WHOIS Verileri',
        'results_for' => 'için Sonuçlar',
        'no_results' => 'Sorgulanan alan adı için sonuç bulunamadı.',
        'error_invalid_domain' => 'Hata: Geçersiz alan adı formatı.',
        'error_no_server' => 'Hata: WHOIS sunucusu bulunamadı.',
        'error_connection' => 'Hata: WHOIS sunucusuna bağlanılamadı.',
        'not_registered_value' => 'Kayıtlı Değil',
        'unknown' => 'Bilinmiyor',
        'quick_check' => 'Hızlı Kontrol',
        'detailed_info' => 'Detaylı Bilgi',
        'footer_text' => 'KD - Domain Check System',
        'powered_by' => '<a href="https://www.egemenkeydal.com/">Egemen KEYDAL</a> tarafından geliştirilmiştir',
        'search_history' => 'Son Aramalar',
        'clear_history' => 'Geçmişi Temizle',
        'features_title' => 'Özellikler',
        'feature_1' => 'Anlık WHOIS Sorgulaması',
        'feature_2' => 'Çoklu TLD Desteği',
        'feature_3' => 'Detaylı Alan Adı Bilgileri',
        'feature_4' => 'Türkçe ve İngilizce Dil Desteği',
    ],
    'en' => [
        'site_title' => 'KD - Domain Check',
        'site_subtitle' => 'Professional domain availability checker',
        'domain_input_label' => 'Domain Name or Domain',
        'domain_input_placeholder' => 'example.com or just example',
        'search_button' => 'Check',
        'registered' => 'Registered',
        'available' => 'Available',
        'domain_status' => 'Domain Status',
        'creation_date' => 'Creation Date',
        'expiration_date' => 'Expiration Date',
        'registrar' => 'Registrar',
        'nameservers' => 'Nameservers',
        'show_details' => 'Show Details',
        'raw_whois' => 'Raw WHOIS Data',
        'results_for' => 'Results for',
        'no_results' => 'No results found for the queried domain.',
        'error_invalid_domain' => 'Error: Invalid domain format.',
        'error_no_server' => 'Error: WHOIS server not found.',
        'error_connection' => 'Error: Could not connect to WHOIS server.',
        'not_registered_value' => 'Not Registered',
        'unknown' => 'Unknown',
        'quick_check' => 'Quick Check',
        'detailed_info' => 'Detailed Info',
        'footer_text' => 'KD - Domain Check System',
        'powered_by' => 'Developed by <a href="https://www.egemenkeydal.com/">Egemen KEYDAL</a>',
        'search_history' => 'Recent Searches',
        'clear_history' => 'Clear History',
        'features_title' => 'Features',
        'feature_1' => 'Real-time WHOIS Queries',
        'feature_2' => 'Multiple TLD Support',
        'feature_3' => 'Detailed Domain Information',
        'feature_4' => 'Turkish and English Language Support',
    ]
];

function t($key) {
    global $translations, $lang;
    return isset($translations[$lang][$key]) ? $translations[$lang][$key] : $key;
}

$whoisServers = [
    'com' => 'whois.verisign-grs.com',
    'net' => 'whois.verisign-grs.com',
    'org' => 'whois.pir.org',
    'biz' => 'whois.neulevel.biz',
    'io' => 'whois.nic.io',
    'co' => 'whois.nic.co',
    'me' => 'whois.nic.me',
    'mobi' => 'whois.dotmobiregistry.net',
    'xyz' => 'whois.nic.xyz',
    'uk' => 'whois.nic.uk',
    'co.uk' => 'whois.nic.uk',
    'de' => 'whois.denic.de',
    'fr' => 'whois.nic.fr',
    'eu' => 'whois.eu',
    'ru' => 'whois.tcinet.ru',
    'app' => 'whois.nic.google',
    'dev' => 'whois.nic.google',
    'tr' => 'whois.nic.tr',
    'com.tr' => 'whois.nic.tr',
    'net.tr' => 'whois.nic.tr',
    'org.tr' => 'whois.nic.tr',
    'edu.tr' => 'whois.nic.tr',
    'gov.tr' => 'whois.nic.tr',
    'mil.tr' => 'whois.nic.tr',
    'biz.tr' => 'whois.nic.tr',
    'info.tr' => 'whois.nic.tr',
    'tv.tr' => 'whois.nic.tr',
    'web.tr' => 'whois.nic.tr',
    'gen.tr' => 'whois.nic.tr',
    'name.tr' => 'whois.nic.tr'
];

$popularTLDs = [
    'com', 'net', 'org', 'biz', 'io', 'co', 'me', 'mobi', 'xyz',
    'uk', 'co.uk', 'de', 'fr', 'eu', 'ru',
    'app', 'dev',
    'tr', 'com.tr', 'net.tr', 'org.tr', 'edu.tr', 'gov.tr', 'mil.tr',
    'biz.tr', 'info.tr', 'tv.tr', 'web.tr', 'gen.tr', 'name.tr'
];


function getWhoisInfo($domain) {
    global $whoisServers;
    
    $domain = strtolower(trim($domain));
    
    if (strpos($domain, '.') !== false) {
        if (!preg_match('/^[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,}$/', $domain)) {
            return t('error_invalid_domain');
        }
        
        $domainParts = explode('.', $domain);
        $tld = implode('.', array_slice($domainParts, 1));
        
        if (!isset($whoisServers[$tld])) {
            if (strpos($tld, '.') !== false) {
                $parts = explode('.', $tld);
                $mainTld = end($parts);
                if (isset($whoisServers[$mainTld])) {
                    $whoisServer = $whoisServers[$mainTld];
                } else {
                    return t('error_no_server') . " ($tld)";
                }
            } else {
                return t('error_no_server') . " ($tld)";
            }
        } else {
            $whoisServer = $whoisServers[$tld];
        }
        
        $port = 43;
        $timeout = 10;
        $fp = @fsockopen($whoisServer, $port, $errno, $errstr, $timeout);
        
        if (!$fp) {
            return t('error_connection') . ": $errstr ($errno)";
        }
        
        $queryDomain = $domain;
        switch ($whoisServer) {
            case 'whois.verisign-grs.com':
                $queryDomain = "domain $domain";
                break;
            case 'whois.denic.de':
                $queryDomain = "-T dn $domain";
                break;
        }
        
        fputs($fp, $queryDomain . "\r\n");
        
        $response = '';
        while (!feof($fp)) {
            $response .= fgets($fp, 128);
        }
        fclose($fp);
        
        if (empty($response)) {
            return t('error_connection');
        }
        
        return $response;
    } else {
        return false;
    }
}

function isDomainRegistered($whoisData) {
    $notFoundPatterns = [
        'No match for',
        'NOT FOUND',
        'No Data Found',
        'Nothing found',
        'Domain not found',
        'The queried object does not exist',
        'Status: free',
        'Status: AVAILABLE',
        'No entries found',
        'Domain Status: AVAILABLE',
        'Domain Status: FREE',
        'Domain not registered',
        'Domain Status: No Object Found',
        'Domain not exist',
        '** NOT FOUND **',
        'Not found:',
        'No match found for',
        'kayıt bulunamadı',
        'mevcut değildir'
    ];
    
    foreach ($notFoundPatterns as $pattern) {
        if (stripos($whoisData, $pattern) !== false) {
            return false;
        }
    }
    
    $lines = explode("\n", $whoisData);
    $percentLineCount = 0;
    foreach ($lines as $line) {
        if (substr(trim($line), 0, 1) === '%') {
            $percentLineCount++;
        }
    }
    
    if (stripos($whoisData, '.tr') !== false && $percentLineCount > 5 && stripos($whoisData, 'Domain Name:') === false && stripos($whoisData, 'Registrar:') === false) {
        return false;
    }
    
    return true;
}

function parseWhoisData($whoisData) {
    $result = [
        'is_registered' => true,
        'domain_status' => t('unknown'),
        'creation_date' => t('unknown'),
        'expiration_date' => t('unknown'),
        'nameservers' => [],
        'registrar' => t('unknown')
    ];
    
    $result['is_registered'] = isDomainRegistered($whoisData);
    
    if (!$result['is_registered']) {
        $result['domain_status'] = t('not_registered_value');
        $result['creation_date'] = t('not_registered_value');
        $result['expiration_date'] = t('not_registered_value');
        $result['registrar'] = t('not_registered_value');
        return $result;
    }
    
    if (preg_match('/Status: ?(.+)/i', $whoisData, $matches) || 
        preg_match('/Domain Status: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Durum: ?(.+)/i', $whoisData, $matches)) {
        $result['domain_status'] = $matches[1];
    }
    
    if (preg_match('/Created Date: ?(.+)/i', $whoisData, $matches) || 
        preg_match('/Creation Date: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Created: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Created on: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Oluşturulma Tarihi: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Created On: ?(.+)/i', $whoisData, $matches)) {
        $result['creation_date'] = trim($matches[1]);
    }
    
    if (preg_match('/Expiry Date: ?(.+)/i', $whoisData, $matches) || 
        preg_match('/Expiration Date: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Registry Expiry Date: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Expiration: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Expires On: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Expires: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Bitiş Tarihi: ?(.+)/i', $whoisData, $matches)) {
        $result['expiration_date'] = trim($matches[1]);
    }
    
    if (preg_match_all('/Name Server: ?(.+)/i', $whoisData, $matches) ||
        preg_match_all('/Name Servers: ?(.+)/i', $whoisData, $matches) ||
        preg_match_all('/Nameservers: ?(.+)/i', $whoisData, $matches) ||
        preg_match_all('/nserver: ?(.+)/i', $whoisData, $matches) ||
        preg_match_all('/Alan Adı Sunucusu: ?(.+)/i', $whoisData, $matches)) {
        foreach ($matches[1] as $nameserver) {
            $result['nameservers'][] = trim($nameserver);
        }
    }
    
    if (empty($result['nameservers'])) {
        $lines = explode("\n", $whoisData);
        foreach ($lines as $line) {
            $line = trim($line);
            if (preg_match('/^NS\s+:\s+(.+)$/i', $line, $nsMatches)) {
                $result['nameservers'][] = trim($nsMatches[1]);
            }
            if (preg_match('/^DNS\s+:\s+(.+)$/i', $line, $dnsMatches)) {
                $result['nameservers'][] = trim($dnsMatches[1]);
            }
        }
    }
    
    if (preg_match('/Registrar: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Registrant: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Sponsoring Registrar: ?(.+)/i', $whoisData, $matches) ||
        preg_match('/Kayıt Şirketi: ?(.+)/i', $whoisData, $matches)) {
        $result['registrar'] = trim($matches[1]);
    }
    
    if (stripos($whoisData, '.tr') !== false) {
        $lines = explode("\n", $whoisData);
        foreach ($lines as $line) {
            $line = trim($line);
            if (preg_match('/^Organization Name\s+:\s+(.+)$/i', $line, $orgMatches)) {
                $result['registrar'] = trim($orgMatches[1]);
            }
            if (preg_match('/^Created on\s+:\s+(.+)$/i', $line, $creationMatches)) {
                $result['creation_date'] = trim($creationMatches[1]);
            }
            if (preg_match('/^Expires on\s+:\s+(.+)$/i', $line, $expiryMatches)) {
                $result['expiration_date'] = trim($expiryMatches[1]);
            }
        }
    }
    
    return $result;
}

$domain = '';
$whoisData = '';
$parsedData = [];
$hasResult = false;
$multiCheck = false;
$multiResults = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['domain'])) {
        $domain = trim($_POST['domain']);
        
        if (!empty($domain)) {
            if (strpos($domain, '.') !== false) {
                $whoisData = getWhoisInfo($domain);
                
                if ($whoisData && strpos($whoisData, t('error_invalid_domain')) !== 0) {
                    $parsedData = parseWhoisData($whoisData);
                    $hasResult = true;
                }
            } else {
                $multiCheck = true;
                
                foreach ($popularTLDs as $tld) {
                    $fullDomain = $domain . '.' . $tld;
                    $whoisData = getWhoisInfo($fullDomain);
                    
                    if ($whoisData && strpos($whoisData, 'Hata:') !== 0 && strpos($whoisData, 'Error:') !== 0) {
                        $parsedInfo = parseWhoisData($whoisData);
                        $multiResults[$tld] = [
                            'domain' => $fullDomain,
                            'data' => $parsedInfo,
                            'raw' => $whoisData
                        ];
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('site_title'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://api.egemenkeydal.app/index/root.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-alt {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .status-badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .8;
            }
        }
        
        .feature-icon {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .modal-backdrop {
            backdrop-filter: blur(5px);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .lang-switcher {
            transition: all 0.3s ease;
        }
        
        .lang-switcher:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50">

<header class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-globe text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold"><?php echo t('site_title'); ?></h1>
                        <p class="text-sm opacity-90"><?php echo t('site_subtitle'); ?></p>
                    </div>
                </div>
                

                <div class="flex space-x-2">
                    <a href="?lang=tr" class="lang-switcher bg-white bg-opacity-<?php echo $lang === 'tr' ? '30' : '10'; ?> px-4 py-2 rounded-lg font-semibold hover:bg-opacity-20">
                        🇹🇷 TR
                    </a>
                    <a href="?lang=en" class="lang-switcher bg-white bg-opacity-<?php echo $lang === 'en' ? '30' : '10'; ?> px-4 py-2 rounded-lg font-semibold hover:bg-opacity-20">
                        🇬🇧 EN
                    </a>
                </div>
            </div>
            

            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 shadow-2xl">
                <form method="post" action="" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="domain" class="block text-sm font-semibold mb-2 opacity-90">
                            <?php echo t('domain_input_label'); ?>
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="domain" 
                                name="domain" 
                                class="search-input w-full px-6 py-4 rounded-xl text-gray-800 font-medium text-lg border-2 border-transparent focus:border-white focus:outline-none transition-all" 
                                placeholder="<?php echo t('domain_input_placeholder'); ?>" 
                                value="<?php echo htmlspecialchars($domain); ?>" 
                                required
                            >
                            <i class="fas fa-search absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full md:w-auto gradient-bg-alt text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>
                            <?php echo t('search_button'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <?php if (!empty($domain)): ?>
            <?php if (!$multiCheck): ?>
                <?php if (!empty($whoisData)): ?>
                    <div class="animate-fade-in">
                        <?php if (strpos($whoisData, 'Hata:') === 0 || strpos($whoisData, 'Error:') === 0): ?>
                            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow-md">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-3"></i>
                                    <p class="text-red-800 font-semibold"><?php echo htmlspecialchars($whoisData); ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                                <div class="gradient-bg p-6 flex justify-between items-center">
                                    <h2 class="text-3xl font-bold text-white flex items-center">
                                        <i class="fas fa-globe mr-3"></i>
                                        <?php echo htmlspecialchars($domain); ?>
                                    </h2>
                                    <?php if ($parsedData['is_registered']): ?>
                                        <span class="status-badge bg-red-500 text-white px-6 py-2 rounded-full font-bold text-sm uppercase tracking-wider">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            <?php echo t('registered'); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge bg-green-500 text-white px-6 py-2 rounded-full font-bold text-sm uppercase tracking-wider">
                                            <i class="fas fa-check mr-2"></i>
                                            <?php echo t('available'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-6 rounded-xl border border-purple-100">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-info-circle text-purple-500 text-xl mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide"><?php echo t('domain_status'); ?></span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($parsedData['domain_status']); ?></p>
                                    </div>
                                    
                                    <div class="bg-gradient-to-br from-green-50 to-teal-50 p-6 rounded-xl border border-green-100">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-calendar-plus text-green-500 text-xl mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide"><?php echo t('creation_date'); ?></span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($parsedData['creation_date']); ?></p>
                                    </div>
                                    
                                    <div class="bg-gradient-to-br from-orange-50 to-red-50 p-6 rounded-xl border border-orange-100">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-calendar-times text-orange-500 text-xl mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide"><?php echo t('expiration_date'); ?></span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($parsedData['expiration_date']); ?></p>
                                    </div>
                                    
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-building text-blue-500 text-xl mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide"><?php echo t('registrar'); ?></span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($parsedData['registrar']); ?></p>
                                    </div>
                                    
                                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 p-6 rounded-xl border border-pink-100 md:col-span-2">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-server text-pink-500 text-xl mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide"><?php echo t('nameservers'); ?></span>
                                        </div>
                                        <div class="space-y-2">
                                            <?php 
                                            if (!empty($parsedData['nameservers'])) {
                                                foreach ($parsedData['nameservers'] as $ns) {
                                                    echo '<p class="text-sm font-medium text-gray-700 bg-white bg-opacity-50 px-3 py-2 rounded-lg">' . htmlspecialchars($ns) . '</p>';
                                                }
                                            } else {
                                                echo '<p class="text-sm font-medium text-gray-500">' . t('not_registered_value') . '</p>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-8 border-t border-gray-200">
                                    <button onclick="toggleRawData()" class="flex items-center text-purple-600 hover:text-purple-800 font-semibold transition-colors">
                                        <i id="rawDataIcon" class="fas fa-chevron-right mr-2 transition-transform"></i>
                                        <?php echo t('raw_whois'); ?>
                                    </button>
                                    <div id="rawWhoisData" class="hidden mt-4 bg-gray-900 text-green-400 p-6 rounded-xl overflow-x-auto">
                                        <pre class="text-sm font-mono"><?php echo htmlspecialchars($whoisData); ?></pre>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="animate-fade-in">
                    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-list-ul text-purple-600 mr-3"></i>
                            <?php echo t('results_for'); ?> "<?php echo htmlspecialchars($domain); ?>"
                        </h2>
                        <p class="text-gray-600"><?php echo count($multiResults); ?> TLD<?php echo $lang === 'en' ? 's' : ''; ?> <?php echo $lang === 'tr' ? 'kontrol edildi' : 'checked'; ?></p>
                    </div>
                    
                    <?php if (empty($multiResults)): ?>
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-yellow-500 text-2xl mr-3"></i>
                                <p class="text-yellow-800 font-semibold"><?php echo t('no_results'); ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <?php foreach ($multiResults as $tld => $result): ?>
                                <div class="card-hover bg-white rounded-xl shadow-lg overflow-hidden border-2 border-transparent hover:border-purple-300 transition-all">
                                    <div class="<?php echo $result['data']['is_registered'] ? 'bg-gradient-to-r from-red-500 to-pink-500' : 'bg-gradient-to-r from-green-500 to-teal-500'; ?> p-4">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-xl font-bold text-white truncate"><?php echo htmlspecialchars($result['domain']); ?></h3>
                                            <?php if ($result['data']['is_registered']): ?>
                                                <i class="fas fa-times-circle text-white text-xl"></i>
                                            <?php else: ?>
                                                <i class="fas fa-check-circle text-white text-xl"></i>
                                            <?php endif; ?>
                                        </div>
                                        <span class="inline-block mt-2 bg-white bg-opacity-30 px-3 py-1 rounded-full text-xs font-bold text-white uppercase tracking-wider">
                                            <?php echo $result['data']['is_registered'] ? t('registered') : t('available'); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="p-5">
                                        <div class="space-y-3">
                                            <div>
                                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1"><?php echo t('creation_date'); ?></p>
                                                <p class="text-sm font-medium text-gray-800 truncate"><?php echo htmlspecialchars($result['data']['creation_date']); ?></p>
                                            </div>
                                            
                                            <div>
                                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1"><?php echo t('registrar'); ?></p>
                                                <p class="text-sm font-medium text-gray-800 truncate"><?php echo htmlspecialchars($result['data']['registrar']); ?></p>
                                            </div>
                                        </div>
                                        
                                        <button onclick='showDomainDetails(<?php echo json_encode($result['domain']); ?>, <?php echo json_encode($result['data']); ?>, <?php echo json_encode($result['raw']); ?>)' class="mt-4 w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all shadow-md hover:shadow-lg">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <?php echo t('show_details'); ?>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="feature-card bg-white rounded-xl shadow-lg p-6 text-center card-hover">
                    <div class="feature-icon bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo t('feature_1'); ?></h3>
                    <p class="text-sm text-gray-600"><?php echo $lang === 'tr' ? 'WHOIS sunucularından anında sonuç alın' : 'Get instant results from WHOIS servers'; ?></p>
                </div>
                
                <div class="feature-card bg-white rounded-xl shadow-lg p-6 text-center card-hover">
                    <div class="feature-icon bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-globe-americas text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo t('feature_2'); ?></h3>
                    <p class="text-sm text-gray-600"><?php echo $lang === 'tr' ? '15+ farklı TLD uzantısı desteği' : 'Support for 15+ different TLD extensions'; ?></p>
                </div>
                
                <div class="feature-card bg-white rounded-xl shadow-lg p-6 text-center card-hover">
                    <div class="feature-icon bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo t('feature_3'); ?></h3>
                    <p class="text-sm text-gray-600"><?php echo $lang === 'tr' ? 'Kapsamlı domain bilgileri ve analiz' : 'Comprehensive domain info and analysis'; ?></p>
                </div>
                
                <div class="feature-card bg-white rounded-xl shadow-lg p-6 text-center card-hover">
                    <div class="feature-icon bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-language text-pink-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2"><?php echo t('feature_4'); ?></h3>
                    <p class="text-sm text-gray-600"><?php echo $lang === 'tr' ? 'Tam Türkçe ve İngilizce arayüz' : 'Full Turkish and English interface'; ?></p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl shadow-xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4 flex items-center">
                        <i class="fas fa-rocket mr-3"></i>
                        <?php echo t('quick_check'); ?>
                    </h3>
                    <p class="text-lg opacity-90 mb-4">
                        <?php echo $lang === 'tr' 
                            ? 'Alan adınızı girin ve anlık olarak müsaitlik durumunu öğrenin. Tek bir sorguda birden fazla uzantıyı kontrol edebilirsiniz.' 
                            : 'Enter your domain and instantly check its availability. Check multiple extensions in a single query.'; ?>
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <?php echo $lang === 'tr' ? 'Hızlı ve güvenilir' : 'Fast and reliable'; ?>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <?php echo $lang === 'tr' ? 'Gerçek zamanlı sonuçlar' : 'Real-time results'; ?>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <?php echo $lang === 'tr' ? 'Çoklu TLD kontrolü' : 'Multiple TLD check'; ?>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-gradient-to-br from-pink-600 to-orange-600 rounded-2xl shadow-xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4 flex items-center">
                        <i class="fas fa-database mr-3"></i>
                        <?php echo t('detailed_info'); ?>
                    </h3>
                    <p class="text-lg opacity-90 mb-4">
                        <?php echo $lang === 'tr' 
                            ? 'Kayıtlı alan adları için detaylı WHOIS bilgilerini görüntüleyin. Tüm teknik detaylara tek tıkla ulaşın.' 
                            : 'View detailed WHOIS information for registered domains. Access all technical details with one click.'; ?>
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <?php echo $lang === 'tr' ? 'Kayıt tarihleri' : 'Registration dates'; ?>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <?php echo $lang === 'tr' ? 'Name server bilgileri' : 'Nameserver information'; ?>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <?php echo $lang === 'tr' ? 'Ham WHOIS verileri' : 'Raw WHOIS data'; ?>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <div id="domainModal" class="hidden fixed inset-0 bg-black bg-opacity-50 modal-backdrop z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto animate-fade-in">
                <div class="gradient-bg p-6 flex justify-between items-center sticky top-0 z-10">
                    <h2 id="modalDomainName" class="text-2xl font-bold text-white"></h2>
                    <button onclick="closeModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                <div class="p-8">
                    <div id="modalStatusBadge" class="inline-block mb-6"></div>
                    
                    <div id="modalInfoGrid" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8"></div>
                    
                    <button onclick="toggleModalRawData()" class="flex items-center text-purple-600 hover:text-purple-800 font-semibold transition-colors mb-4">
                        <i id="modalRawDataIcon" class="fas fa-chevron-right mr-2 transition-transform"></i>
                        <?php echo t('raw_whois'); ?>
                    </button>
                    <div id="modalRawWhoisData" class="hidden bg-gray-900 text-green-400 p-6 rounded-xl overflow-x-auto">
                        <pre id="modalRawWhoisContent" class="text-sm font-mono"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-bold mb-2"><?php echo t('footer_text'); ?></h3>
                    <p class="text-gray-400 text-sm"><?php echo t('powered_by'); ?></p>
                </div>
                <div class="flex space-x-6">
                    <a href="https://github.com/EgemenKEYDAL" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-github text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-web text-2xl"></i>
                    </a>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-6 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; <?php echo date('Y'); ?> Egemen KEYDAL <?php echo $lang === 'tr' ? ' | Tüm hakları saklıdır.' : 'All rights reserved.'; ?></p>
            </div>
        </div>
    </footer>

    <script>
        function toggleRawData() {
            const rawDataElement = document.getElementById('rawWhoisData');
            const icon = document.getElementById('rawDataIcon');
            
            rawDataElement.classList.toggle('hidden');
            
            if (rawDataElement.classList.contains('hidden')) {
                icon.style.transform = 'rotate(0deg)';
            } else {
                icon.style.transform = 'rotate(90deg)';
            }
        }
        
        function showDomainDetails(domain, data, rawData) {
            const modal = document.getElementById('domainModal');
            const domainNameElement = document.getElementById('modalDomainName');
            const statusBadgeElement = document.getElementById('modalStatusBadge');
            const infoGridElement = document.getElementById('modalInfoGrid');
            const rawWhoisContent = document.getElementById('modalRawWhoisContent');
            
            domainNameElement.textContent = domain;
            
            const lang = '<?php echo $lang; ?>';
            const registeredText = lang === 'tr' ? 'Kayıtlı' : 'Registered';
            const availableText = lang === 'tr' ? 'Müsait' : 'Available';
            const statusClass = data.is_registered ? 'bg-red-500' : 'bg-green-500';
            const statusIcon = data.is_registered ? 'fa-check-circle' : 'fa-check';
            const statusText = data.is_registered ? registeredText : availableText;
            
            statusBadgeElement.className = `${statusClass} text-white px-6 py-2 rounded-full font-bold text-sm uppercase tracking-wider`;
            statusBadgeElement.innerHTML = `<i class="fas ${statusIcon} mr-2"></i>${statusText}`;
            
            const labels = {
                tr: {
                    domain_status: 'Alan Adı Durumu',
                    creation_date: 'Oluşturma Tarihi',
                    expiration_date: 'Bitiş Tarihi',
                    registrar: 'Kayıt Şirketi',
                    nameservers: 'Alan Adı Sunucuları',
                    not_registered: 'Kayıtlı Değil'
                },
                en: {
                    domain_status: 'Domain Status',
                    creation_date: 'Creation Date',
                    expiration_date: 'Expiration Date',
                    registrar: 'Registrar',
                    nameservers: 'Nameservers',
                    not_registered: 'Not Registered'
                }
            };
            
            const l = labels[lang];
            
            let nameserversHTML = '';
            if (data.nameservers && data.nameservers.length > 0) {
                nameserversHTML = data.nameservers.map(ns => 
                    `<p class="text-sm font-medium text-gray-700 bg-gray-50 px-3 py-2 rounded-lg">${ns}</p>`
                ).join('');
            } else {
                nameserversHTML = `<p class="text-sm font-medium text-gray-500">${l.not_registered}</p>`;
            }
            
            infoGridElement.innerHTML = `
                <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-6 rounded-xl border border-purple-100">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-info-circle text-purple-500 text-xl mr-3"></i>
                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">${l.domain_status}</span>
                    </div>
                    <p class="text-lg font-bold text-gray-800">${data.domain_status}</p>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-teal-50 p-6 rounded-xl border border-green-100">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-calendar-plus text-green-500 text-xl mr-3"></i>
                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">${l.creation_date}</span>
                    </div>
                    <p class="text-lg font-bold text-gray-800">${data.creation_date}</p>
                </div>
                
                <div class="bg-gradient-to-br from-orange-50 to-red-50 p-6 rounded-xl border border-orange-100">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-calendar-times text-orange-500 text-xl mr-3"></i>
                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">${l.expiration_date}</span>
                    </div>
                    <p class="text-lg font-bold text-gray-800">${data.expiration_date}</p>
                </div>
                
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-building text-blue-500 text-xl mr-3"></i>
                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">${l.registrar}</span>
                    </div>
                    <p class="text-lg font-bold text-gray-800">${data.registrar}</p>
                </div>
                
                <div class="bg-gradient-to-br from-pink-50 to-purple-50 p-6 rounded-xl border border-pink-100 md:col-span-2">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-server text-pink-500 text-xl mr-3"></i>
                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">${l.nameservers}</span>
                    </div>
                    <div class="space-y-2">
                        ${nameserversHTML}
                    </div>
                </div>
            `;
            
            rawWhoisContent.textContent = rawData;
            document.getElementById('modalRawWhoisData').classList.add('hidden');
            document.getElementById('modalRawDataIcon').style.transform = 'rotate(0deg)';
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            const modal = document.getElementById('domainModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        function toggleModalRawData() {
            const rawDataElement = document.getElementById('modalRawWhoisData');
            const icon = document.getElementById('modalRawDataIcon');
            
            rawDataElement.classList.toggle('hidden');
            
            if (rawDataElement.classList.contains('hidden')) {
                icon.style.transform = 'rotate(0deg)';
            } else {
                icon.style.transform = 'rotate(90deg)';
            }
        }
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
        
        document.getElementById('domainModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>