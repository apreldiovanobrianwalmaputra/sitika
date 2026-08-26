<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role !== 'TEKNISI') {
            abort(403);
        }

        $clientIp = $request->ip();

        $serverIp = $request->server('SERVER_ADDR')
            ?? gethostbyname(gethostname());

        $host = $request->getHost();
        $port = $request->getPort();

        $protocol = $request->server(
            'SERVER_PROTOCOL',
            'Tidak diketahui'
        );

        $scheme = strtoupper(
            $request->getScheme()
        );

        $userAgent = $request->userAgent()
            ?? 'Tidak diketahui';

        $clientIpType = $this->classifyIp($clientIp);
        $serverIpType = $this->classifyIp($serverIp);

        return view('network.index', compact(
            'clientIp',
            'serverIp',
            'clientIpType',
            'serverIpType',
            'host',
            'port',
            'protocol',
            'scheme',
            'userAgent'
        ));
    }

    private function classifyIp(?string $ip): string
    {
        if (!$ip) {
            return 'Tidak diketahui';
        }

        if (
            $ip === '127.0.0.1' ||
            $ip === '::1'
        ) {
            return 'Loopback / localhost';
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return 'Alamat IP tidak valid';
        }

        $publicIp = filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE |
            FILTER_FLAG_NO_RES_RANGE
        );

        return $publicIp !== false
            ? 'Publik'
            : 'Privat / lokal';
    }
}