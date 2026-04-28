<?php

declare(strict_types=1);

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\Output\QRGdImagePNG;
use chillerlan\QRCode\Common\EccLevel;

class QrService
{
    public function generate(string $data, string $format = 'svg'): string
    {
        $options = new QROptions([
            'version'         => 5,
            'outputInterface' => $format === 'png' ? QRGdImagePNG::class : QRMarkupSVG::class,
            'eccLevel'        => EccLevel::L,
            'addQuietzone'    => true,
            'imageBase64'     => true,
        ]);

        return (new QRCode($options))->render($data);
    }
}
